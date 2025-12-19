<?php

namespace App\Http\Requests\Auth;

use App\Helpers\TurnstileHelper;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $value = trim((string) $value);

                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return;
                    }

                    $digits = preg_replace('/\D+/', '', $value);

                    if (strlen($digits) < 8) {
                        $fail('Masukkan email atau nomor telepon yang valid.');
                    }
                },
            ],
            'password' => ['required', 'string'],
        ];

        if ($this->shouldValidateTurnstile()) {
            $rules['cf-turnstile-response'] = ['required', 'string'];
        }

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        if ($this->shouldValidateTurnstile()) {
            $validator->after(function ($validator) {
                $token = $this->input('cf-turnstile-response');
                
                if ($token && !TurnstileHelper::verify($token, $this->ip())) {
                    $validator->errors()->add('cf-turnstile-response', 'Verifikasi CAPTCHA gagal. Silakan coba lagi.');
                }
            });
        }
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = trim((string) $this->input('email'));
        $password = (string) $this->input('password');
        $remember = $this->boolean('remember');

        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            if (! Auth::attempt(['email' => $loginInput, 'password' => $password], $remember)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        } else {
            $user = $this->findUserByPhone($loginInput);

            if (! $user || ! Hash::check($password, $user->password)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            Auth::login($user, $remember);
        }

        /*
        // Check if student is active
        $user = Auth::user();
        if ($user && $user->role === 'siswa' && !$user->is_active) {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi admin untuk mengaktifkan kembali.',
            ]);
        }
        */

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $loginInput = trim((string) $this->input('email'));

        return Str::transliterate(Str::lower($loginInput).'|'.$this->ip());
    }

    /**
     * Find a user by phone number considering different formatting variants.
     */
    protected function findUserByPhone(string $value): ?User
    {
        $candidates = $this->phoneCandidates($value);

        if (empty($candidates)) {
            return null;
        }

        return User::whereIn('no_telepon', $candidates)->first();
    }

    /**
     * Build possible variants for a phone number (raw, digits, international).
     */
    protected function phoneCandidates(string $value): array
    {
        $raw = trim($value);
        $digits = preg_replace('/\D+/', '', $raw);

        $variants = [];

        if ($raw !== '') {
            $variants[] = $raw;
        }

        if ($digits !== '') {
            $variants[] = $digits;
            $variants[] = '+' . $digits;

            if (Str::startsWith($digits, '0')) {
                $withoutZero = ltrim($digits, '0');
                if ($withoutZero !== '') {
                    $variants[] = '0' . $withoutZero;
                    $variants[] = '62' . $withoutZero;
                    $variants[] = '+62' . $withoutZero;
                }
            } elseif (Str::startsWith($digits, '62')) {
                $local = substr($digits, 2);
                if ($local !== '') {
                    $variants[] = '0' . $local;
                    $variants[] = '+62' . $local;
                    $variants[] = '62' . $local;
                }
            } elseif (Str::startsWith($digits, '8')) {
                $variants[] = '0' . $digits;
                $variants[] = '62' . $digits;
                $variants[] = '+62' . $digits;
            }
        }

        return array_values(array_unique(array_filter($variants)));
    }

    /**
     * Determine if Turnstile validation should run.
     */
    protected function shouldValidateTurnstile(): bool
    {
        // Only enable Turnstile in production environment
        if (! app()->isProduction()) {
            return false;
        }

        return (bool) config('services.turnstile.enabled')
            && ! empty(config('services.turnstile.site_key'))
            && ! empty(config('services.turnstile.secret_key'));
    }
}
