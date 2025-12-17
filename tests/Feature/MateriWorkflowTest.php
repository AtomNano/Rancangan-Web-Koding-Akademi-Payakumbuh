<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MateriWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function makeGuru()
    {
        return User::factory()->create([
            'role' => 'guru',
        ]);
    }

    protected function makeAdmin()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    protected function createKelasWithGuru($guru)
    {
        return Kelas::create([
            'nama_kelas' => 'Materi Test Class',
            'deskripsi' => 'Test class',
            'guru_id' => $guru->id,
            'bidang' => 'Programming',
            'status' => 'aktif',
        ]);
    }

    public function test_guru_can_view_materi_list(): void
    {
        $guru = $this->makeGuru();

        $response = $this->actingAs($guru)->get('/guru/materi');

        $response->assertStatus(200);
    }



    public function test_guru_can_view_materi_create_form(): void
    {
        $guru = $this->makeGuru();

        $response = $this->actingAs($guru)->get('/guru/materi/create');

        $response->assertStatus(200);
    }

    public function test_guru_can_view_materi_detail(): void
    {
        Storage::fake('public');
        
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        $materi = Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => 'React Basics',
            'file_path' => UploadedFile::fake()->create('react.pdf', 300)->store('materi', 'public'),
            'status' => 'pending',
            'uploaded_by' => $guru->id,
        ]);

        $response = $this->actingAs($guru)->get("/guru/materi/{$materi->id}");

        $response->assertStatus(200);
        $response->assertSee('React Basics');
    }

    public function test_admin_can_view_pending_materi(): void
    {
        Storage::fake('public');
        
        $admin = $this->makeAdmin();
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        $materi = Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => 'Python Intro',
            'file_path' => UploadedFile::fake()->create('python.pdf', 250)->store('materi', 'public'),
            'status' => 'pending',
            'uploaded_by' => $guru->id,
        ]);

        $response = $this->actingAs($admin)->get('/admin/materi');

        $response->assertStatus(200);
        $response->assertSee('Python Intro');
    }





    public function test_guru_can_edit_pending_materi(): void
    {
        Storage::fake('public');
        
        $guru = $this->makeGuru();
        $kelas = $this->createKelasWithGuru($guru);

        $materi = Materi::create([
            'kelas_id' => $kelas->id,
            'judul' => 'Old Title',
            'file_path' => UploadedFile::fake()->create('doc.pdf', 200)->store('materi', 'public'),
            'status' => 'pending',
            'uploaded_by' => $guru->id,
        ]);

        $response = $this->actingAs($guru)->get("/guru/materi/{$materi->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Old Title');
    }




}
