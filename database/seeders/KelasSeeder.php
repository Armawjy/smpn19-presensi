<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['nama_kelas' => 'VII-A', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh Unggulan A'],
            ['nama_kelas' => 'VII-B', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh B'],
            ['nama_kelas' => 'VII-C', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh C'],
            ['nama_kelas' => 'VII-D', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh D'],
            ['nama_kelas' => 'VII-E', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh E'],
            ['nama_kelas' => 'VII-F', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh F'],
            ['nama_kelas' => 'VII-G', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh G'],
            ['nama_kelas' => 'VII-H', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh H'],
            ['nama_kelas' => 'VII-I', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh I'],
            ['nama_kelas' => 'VII-J', 'wali_kelas_id' => null, 'status' => 'aktif', 'deskripsi' => 'Kelas Tujuh J'],
        ];

        foreach ($classes as $c) {
            Kelas::create($c);
        }
    }
}
