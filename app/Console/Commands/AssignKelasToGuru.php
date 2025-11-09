<?php

namespace App\Console\Commands;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Console\Command;

class AssignKelasToGuru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kelas:assign {kelas_id} {guru_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign kelas to guru';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $kelasId = $this->argument('kelas_id');
        $guruId = $this->argument('guru_id');

        $kelas = Kelas::find($kelasId);
        $guru = User::find($guruId);

        if (!$kelas) {
            $this->error("Kelas dengan ID {$kelasId} tidak ditemukan.");
            return 1;
        }

        if (!$guru) {
            $this->error("Guru dengan ID {$guruId} tidak ditemukan.");
            return 1;
        }

        if ($guru->role !== 'guru') {
            $this->error("User dengan ID {$guruId} bukan guru.");
            return 1;
        }

        $kelas->guru_id = $guruId;
        $kelas->save();

        $this->info("Kelas '{$kelas->nama_kelas}' berhasil diassign ke guru '{$guru->name}' (ID: {$guruId})");
        
        return 0;
    }
}

