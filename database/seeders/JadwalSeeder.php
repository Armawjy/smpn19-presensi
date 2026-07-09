<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kelas = Kelas::all();
        $gurus = Guru::all();
        $mapels = MataPelajaran::all();

        if ($gurus->isEmpty() || $mapels->isEmpty()) {
            return;
        }

        foreach ($kelas as $k) {
            foreach ($days as $index => $day) {
                // Hari Senin-Jumat, buat 2 jadwal per hari per kelas
                // Jadwal 1
                Jadwal::create([
                    'kelas_id' => $k->id,
                    'guru_id' => $gurus->random()->id,
                    'mata_pelajaran_id' => $mapels->random()->id,
                    'hari' => $day,
                    'jam_mulai' => '07:30:00',
                    'jam_selesai' => '09:00:00',
                ]);

                // Jadwal 2
                Jadwal::create([
                    'kelas_id' => $k->id,
                    'guru_id' => $gurus->random()->id,
                    'mata_pelajaran_id' => $mapels->random()->id,
                    'hari' => $day,
                    'jam_mulai' => '09:30:00',
                    'jam_selesai' => '11:00:00',
                ]);
            }
        }
    }
}
