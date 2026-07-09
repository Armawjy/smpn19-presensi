<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['nama' => 'Pendidikan Agama Islam', 'deskripsi' => 'Mata pelajaran Agama Islam', 'status' => 'aktif'],
            ['nama' => 'PKN', 'deskripsi' => 'Pendidikan Kewarganegaraan', 'status' => 'aktif'],
            ['nama' => 'Bahasa Indonesia', 'deskripsi' => 'Mata pelajaran Bahasa Indonesia', 'status' => 'aktif'],
            ['nama' => 'Matematika', 'deskripsi' => 'Mata pelajaran Matematika', 'status' => 'aktif'],
            ['nama' => 'IPA', 'deskripsi' => 'Ilmu Pengetahuan Alam', 'status' => 'aktif'],
            ['nama' => 'IPS', 'deskripsi' => 'Ilmu Pengetahuan Sosial', 'status' => 'aktif'],
            ['nama' => 'Bahasa Inggris', 'deskripsi' => 'Mata pelajaran Bahasa Inggris', 'status' => 'aktif'],
            ['nama' => 'Seni Budaya', 'deskripsi' => 'Seni dan Kebudayaan', 'status' => 'aktif'],
            ['nama' => 'PJOK', 'deskripsi' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan', 'status' => 'aktif'],
            ['nama' => 'Prakarya', 'deskripsi' => 'Keterampilan dan Prakarya', 'status' => 'aktif'],
        ];

        foreach ($subjects as $s) {
            MataPelajaran::create($s);
        }
    }
}
