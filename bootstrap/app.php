<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'guru' => \App\Http\Middleware\GuruMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
        ]);
        
        // Trust reverse proxies (e.g., Hostinger/Cloudflare) so HTTPS and
        // X-Forwarded headers are honored for secure cookies and CSRF/session.
        $middleware->trustProxies(at: '*');
        
        // Add middleware to increase POST size limits
        // Note: This runs early but upload_max_filesize and post_max_size
        // must be set in php.ini and server must be restarted
        $middleware->web(append: [
            \App\Http\Middleware\IncreasePostSize::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle POST size too large error with better message
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'File terlalu besar. Ukuran maksimum: ' . ini_get('upload_max_filesize'),
                    'upload_max_size' => ini_get('upload_max_filesize'),
                    'post_max_size' => ini_get('post_max_size'),
                ], 413);
            }
            
            return response()->view('errors.upload-too-large', [
                'maxSize' => ini_get('post_max_size'),
                'uploadMaxSize' => ini_get('upload_max_filesize'),
            ], 413);
        });
    })->create();
