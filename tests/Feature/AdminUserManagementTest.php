<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_users_page(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_guru_list(): void
    {
        $admin = $this->makeAdmin();
        User::factory()->create(['role' => 'guru', 'name' => 'Test Guru']);

        $response = $this->actingAs($admin)->get('/admin/users?role=guru');

        $response->assertStatus(200);
        $response->assertSee('Test Guru');
    }

    public function test_admin_can_view_siswa_list(): void
    {
        $admin = $this->makeAdmin();
        User::factory()->create(['role' => 'siswa', 'name' => 'Test Siswa']);

        $response = $this->actingAs($admin)->get('/admin/users?role=siswa');

        $response->assertStatus(200);
        $response->assertSee('Test Siswa');
    }

    public function test_admin_can_view_user_detail(): void
    {
        $admin = $this->makeAdmin();
        $guru = User::factory()->create(['role' => 'guru', 'name' => 'Guru Detail']);

        $response = $this->actingAs($admin)->get("/admin/users/{$guru->id}");

        $response->assertStatus(200);
        $response->assertSee('Guru Detail');
    }

    public function test_admin_can_view_create_user_form(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get('/admin/users/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_edit_user_form(): void
    {
        $admin = $this->makeAdmin();
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($admin)->get("/admin/users/{$siswa->id}/edit");

        $response->assertStatus(200);
    }

    public function test_unauthorized_guru_cannot_access_user_management(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $response = $this->actingAs($guru)->get('/admin/users');

        $response->assertStatus(302); // Redirect to home
    }

    public function test_unauthorized_siswa_cannot_access_user_management(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswa)->get('/admin/users');

        $response->assertStatus(302); // Redirect to home
    }
}
