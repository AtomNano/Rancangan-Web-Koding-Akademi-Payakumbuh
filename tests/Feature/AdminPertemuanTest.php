<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AdminPertemuanTest extends TestCase
{
    use RefreshDatabase;

    protected function makeAdmin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    protected function makeGuru()
    {
        return User::factory()->create([
            'role' => 'guru',
        ]);
    }

    protected function makeSiswa()
    {
        return User::factory()->create([
            'role' => 'siswa',
        ]);
    }

    public function test_admin_can_view_pertemuan_select_page(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();

        $kelas = Kelas::create([
            'nama_kelas' => 'Kelas A',
            'deskripsi' => 'Deskripsi kelas',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get('/admin/pertemuan');

        $response->assertStatus(200);
        $response->assertSee('Kelas A');
    }

    public function test_admin_can_view_pertemuan_index_for_class(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();

        $kelas = Kelas::create([
            'nama_kelas' => 'Kelas B',
            'deskripsi' => 'Deskripsi kelas',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);

        Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Pertemuan 1',
            'deskripsi' => 'Intro',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
            'materi' => 'Materi 1',
        ]);

        $response = $this->actingAs($admin)->get("/admin/kelas/{$kelas->id}/pertemuan");

        $response->assertStatus(200);
        $response->assertSee('Pertemuan 1');
    }

    public function test_admin_can_view_absen_detail(): void
    {
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();
        $siswa = $this->makeSiswa();

        $kelas = Kelas::create([
            'nama_kelas' => 'Kelas C',
            'deskripsi' => 'Deskripsi kelas',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Pertemuan 2',
            'deskripsi' => 'Topik 2',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
            'materi' => 'Materi 2',
        ]);

        Presensi::create([
            'user_id' => $siswa->id,
            'pertemuan_id' => $pertemuan->id,
            'status_kehadiran' => 'hadir',
            'tanggal_akses' => now(),
        ]);

        $response = $this->actingAs($admin)->get("/admin/kelas/{$kelas->id}/pertemuan/{$pertemuan->id}/absen-detail");

        $response->assertStatus(200);
        $response->assertSee('Pertemuan 2');
        $response->assertSee($siswa->name);
    }
}
