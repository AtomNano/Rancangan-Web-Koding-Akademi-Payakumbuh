<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Pertemuan;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruPertemuanTest extends TestCase
{
    use RefreshDatabase;

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

    protected function createKelasWithGuru($guru)
    {
        return Kelas::create([
            'nama_kelas' => 'Kelas Test',
            'deskripsi' => 'Test description',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);
    }

    public function test_guru_can_view_pertemuan_index(): void
    {
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Meeting 1',
            'deskripsi' => 'Intro',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
        ]);

        $response = $this->actingAs($guru)->get("/guru/kelas/{$kelas->id}/pertemuan");

        $response->assertStatus(200);
        $response->assertSee('Meeting 1');
    }

    public function test_guru_can_view_create_pertemuan_form(): void
    {
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        $response = $this->actingAs($guru)->get("/guru/kelas/{$kelas->id}/pertemuan/create");

        $response->assertStatus(200);
    }



    public function test_guru_can_view_pertemuan_show(): void
    {
        $guru = $this->makeGuru();
        $siswa = $this->makeSiswa();
        $kelas = $this->createKelasWithGuru($guru);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Session A',
            'deskripsi' => 'Details',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
        ]);

        $response = $this->actingAs($guru)->get("/guru/kelas/{$kelas->id}/pertemuan/{$pertemuan->id}");

        $response->assertStatus(200);
        $response->assertSee('Session A');
    }



    public function test_guru_can_view_absen_detail(): void
    {
        $guru = $this->makeGuru();
        $siswa = $this->makeSiswa();
        $kelas = $this->createKelasWithGuru($guru);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Session C',
            'deskripsi' => 'Details',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
        ]);

        Presensi::create([
            'user_id' => $siswa->id,
            'pertemuan_id' => $pertemuan->id,
            'status_kehadiran' => 'hadir',
            'tanggal_akses' => now(),
        ]);

        $response = $this->actingAs($guru)->get("/guru/kelas/{$kelas->id}/pertemuan/{$pertemuan->id}/absen-detail");

        $response->assertStatus(200);
        $response->assertSee('Session C');
    }

    public function test_guru_can_edit_pertemuan(): void
    {
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        $pertemuan = Pertemuan::create([
            'kelas_id' => $kelas->id,
            'judul_pertemuan' => 'Old Title',
            'deskripsi' => 'Old desc',
            'tanggal_pertemuan' => now()->toDateString(),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '10:00',
            'guru_id' => $guru->id,
        ]);

        $response = $this->actingAs($guru)->get("/guru/kelas/{$kelas->id}/pertemuan/{$pertemuan->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Old Title');
    }


}
