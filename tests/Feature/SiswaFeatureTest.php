<?php

namespace Tests\Feature;

use App\Models\Enrollment;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiswaFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function makeSiswa()
    {
        return User::factory()->create([
            'role' => 'siswa',
        ]);
    }

    protected function makeGuru()
    {
        return User::factory()->create([
            'role' => 'guru',
        ]);
    }

    protected function createKelasWithGuru($guru)
    {
        return Kelas::create([
            'nama_kelas' => 'Kelas Web',
            'deskripsi' => 'Web class',
            'guru_id' => $guru->id,
            'bidang' => 'Web',
            'status' => 'aktif',
        ]);
    }

    public function test_siswa_can_view_enrolled_kelas(): void
    {
        $siswa = $this->makeSiswa();
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        // Enroll siswa
        Enrollment::create([
            'kelas_id' => $kelas->id,
            'user_id' => $siswa->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($siswa)->get("/siswa/kelas/{$kelas->id}");

        $response->assertStatus(200);
        $response->assertSee('Kelas Web');
    }

    public function test_siswa_can_view_materi_in_kelas(): void
    {
        $siswa = $this->makeSiswa();
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        // Enroll siswa
        Enrollment::create([
            'kelas_id' => $kelas->id,
            'user_id' => $siswa->id,
            'status' => 'active',
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->create('doc.pdf', 100);

        $materi = Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => 'Introduction to Web',
            'file_path' => $file->store('materi', 'public'),
            'status' => 'approved',
            'uploaded_by' => $guru->id,
        ]);

        $response = $this->actingAs($siswa)->get("/siswa/materi/{$materi->id}");

        $response->assertStatus(200);
        $response->assertSee('Introduction to Web');
    }

    public function test_siswa_can_view_progress(): void
    {
        $siswa = $this->makeSiswa();
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        // Enroll siswa
        Enrollment::create([
            'kelas_id' => $kelas->id,
            'user_id' => $siswa->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($siswa)->get('/siswa/progress');

        $response->assertStatus(200);
    }

    public function test_siswa_can_view_dashboard(): void
    {
        $siswa = $this->makeSiswa();

        $response = $this->actingAs($siswa)->get('/siswa/dashboard');

        $response->assertStatus(200);
    }

    public function test_siswa_cannot_view_unauthorized_kelas(): void
    {
        $siswa = $this->makeSiswa();
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        // Don't enroll siswa

        $response = $this->actingAs($siswa)->get("/siswa/kelas/{$kelas->id}");

        $response->assertStatus(403);
    }
}
