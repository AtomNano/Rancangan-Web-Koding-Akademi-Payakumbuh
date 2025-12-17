<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKelasManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    protected function makeGuru()
    {
        return User::factory()->create(['role' => 'guru']);
    }

    public function test_admin_can_view_kelas_page(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get('/admin/kelas');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_kelas_list(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();

        Kelas::create([
            'nama_kelas' => 'Web Development',
            'deskripsi' => 'Learn web dev',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get('/admin/kelas');

        $response->assertStatus(200);
        $response->assertSee('Web Development');
    }

    public function test_admin_can_view_kelas_detail(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();

        $kelas = Kelas::create([
            'nama_kelas' => 'Mobile App Dev',
            'deskripsi' => 'Learn mobile apps',
            'guru_id' => $guru->id,
            'bidang' => 'Mobile',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get("/admin/kelas/{$kelas->id}");

        $response->assertStatus(200);
        $response->assertSee('Mobile App Dev');
    }

    public function test_admin_can_view_create_kelas_form(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->get('/admin/kelas/create');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_edit_kelas_form(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();

        $kelas = Kelas::create([
            'nama_kelas' => 'Database Design',
            'deskripsi' => 'Learn databases',
            'guru_id' => $guru->id,
            'bidang' => 'Database',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get("/admin/kelas/{$kelas->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Database Design');
    }


    public function test_unauthorized_guru_cannot_access_kelas_management(): void
    {
        $guru = $this->makeGuru();

        $response = $this->actingAs($guru)->get('/admin/kelas');

        $response->assertStatus(302); // Redirect to home
    }

    public function test_unauthorized_siswa_cannot_access_kelas_management(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswa)->get('/admin/kelas');

        $response->assertStatus(302); // Redirect to home
    }
}
