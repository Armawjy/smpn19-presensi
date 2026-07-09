<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\WaliSiswa;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Administrator SMPN 19 Makassar',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Guru
        $gurus = [
            [
                'name' => 'Dr. Ahmad Syarif, M.Pd',
                'email' => 'ahmadsyarif@gmail.com',
                'password' => Hash::make('ahmad123'),
                'nip' => '198501012010011001',
                'alamat' => 'Jl. Pendidikan No. 45, Makassar',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
            ],
            [
                'name' => 'Dra. Siti Rahmawati, M.Si',
                'email' => 'sitirahmawati@gmail.com',
                'password' => Hash::make('siti123'),
                'nip' => '198702152012012002',
                'alamat' => 'Jl. Kemakmuran No. 78, Makassar',
                'no_hp' => '081298765432',
                'jenis_kelamin' => 'P',
            ],
            [
                'name' => 'Drs. Budi Santoso, M.Pd',
                'email' => 'budisantoso@gmail.com',
                'password' => Hash::make('budi123'),
                'nip' => '197603102005011003',
                'alamat' => 'Jl. Merdeka No. 23, Makassar',
                'no_hp' => '081255512345',
                'jenis_kelamin' => 'L',
            ]
        ];

        foreach ($gurus as $g) {
            $user = User::create([
                'name' => $g['name'],
                'email' => $g['email'],
                'password' => $g['password'],
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $g['nip'],
                'alamat' => $g['alamat'],
                'no_hp' => $g['no_hp'],
                'jenis_kelamin' => $g['jenis_kelamin'],
            ]);
        }

        // 3. Siswa (10 orang)
        $siswas = [
            [
                'name' => 'Andi Muhammad Fauzan',
                'email' => 'andifauzan@gmail.com',
                'password' => Hash::make('andi123'),
                'nis' => '2023001',
                'kelas_id' => 1, // VII-A
                'no_hp' => '082112345678',
                'alamat' => 'Jl. Sultan Hasanuddin No. 12, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'qr_code' => 'QR-2023001',
            ],
            [
                'name' => 'Nurul Aisyah Putri',
                'email' => 'nurulaisyah@gmail.com',
                'password' => Hash::make('nurul123'),
                'nis' => '2023002',
                'kelas_id' => 1,
                'no_hp' => '082198765432',
                'alamat' => 'Jl. Gunung Bawakaraeng No. 5, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'qr_code' => 'QR-2023002',
            ],
            [
                'name' => 'Muhammad Rizky Pratama',
                'email' => 'rizkypatama@gmail.com',
                'password' => Hash::make('rizky123'),
                'nis' => '2023003',
                'kelas_id' => 1,
                'no_hp' => '081345678901',
                'alamat' => 'Jl. Hertasning No. 89, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'qr_code' => 'QR-2023003',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'sitinurhaliza@gmail.com',
                'password' => Hash::make('siti123'),
                'nis' => '2023004',
                'kelas_id' => 2, // VII-B
                'no_hp' => '081356789012',
                'alamat' => 'Jl. Perintis Kemerdekaan No. 34, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'qr_code' => 'QR-2023004',
            ],
            [
                'name' => 'Ahmad Zainuddin',
                'email' => 'ahmadzainuddin@gmail.com',
                'password' => Hash::make('ahmad123'),
                'nis' => '2023005',
                'kelas_id' => 2,
                'no_hp' => '081367890123',
                'alamat' => 'Jl. Urip Sumoharjo No. 67, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'qr_code' => 'QR-2023005',
            ],
            [
                'name' => 'Putri Ramadhani',
                'email' => 'putriramadhani@gmail.com',
                'password' => Hash::make('putri123'),
                'nis' => '2023006',
                'kelas_id' => 2,
                'no_hp' => '081378901234',
                'alamat' => 'Jl. Sungai Saddang No. 45, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'qr_code' => 'QR-2023006',
            ],
            [
                'name' => 'Muhammad Fadil',
                'email' => 'muhammadfadil@gmail.com',
                'password' => Hash::make('fadil123'),
                'nis' => '2023007',
                'kelas_id' => 3, // VII-C
                'no_hp' => '081389012345',
                'alamat' => 'Jl. Monginsidi No. 56, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'qr_code' => 'QR-2023007',
            ],
            [
                'name' => 'Nadia Salsabila',
                'email' => 'nadiasalsabila@gmail.com',
                'password' => Hash::make('nadia123'),
                'nis' => '2023008',
                'kelas_id' => 3,
                'no_hp' => '081390123456',
                'alamat' => 'Jl. P. Makkasau No. 78, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'qr_code' => 'QR-2023008',
            ],
            [
                'name' => 'Rahmat Hidayat',
                'email' => 'rahmathidayat@gmail.com',
                'password' => Hash::make('rahmat123'),
                'nis' => '2023009',
                'kelas_id' => 3,
                'no_hp' => '081401234567',
                'alamat' => 'Jl. A. P. Pettarani No. 90, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'L',
                'qr_code' => 'QR-2023009',
            ],
            [
                'name' => 'Hikmah Wahyuni',
                'email' => 'hikmahwahyuni@gmail.com',
                'password' => Hash::make('hikmah123'),
                'nis' => '2023010',
                'kelas_id' => 4, // VII-D
                'no_hp' => '081412345678',
                'alamat' => 'Jl. Sultan Alauddin No. 12, Makassar',
                'agama' => 'Islam',
                'jenis_kelamin' => 'P',
                'qr_code' => 'QR-2023010',
            ]
        ];

        foreach ($siswas as $s) {
            $user = User::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => $s['password'],
                'role' => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $s['nis'],
                'kelas_id' => $s['kelas_id'],
                'no_hp' => $s['no_hp'],
                'alamat' => $s['alamat'],
                'agama' => $s['agama'],
                'jenis_kelamin' => $s['jenis_kelamin'],
                'qr_code' => $s['qr_code'],
            ]);
        }

        // 4. Wali Siswa (3 orang)
        // Hubungkan ke siswa 1, 2, dan 3 yang ada di database.
        // Siswa 1 = Andi Muhammad Fauzan, Siswa 2 = Nurul Aisyah, Siswa 3 = Muhammad Rizky
        $walis = [
            [
                'name' => 'H. Muhammad Arifin, S.E.',
                'email' => 'arifin@gmail.com',
                'password' => Hash::make('arifin123'),
                'siswa_nis' => '2023001',
                'hubungan' => 'Ayah',
                'no_hp' => '081234567891',
            ],
            [
                'name' => 'Dra. Hj. Siti Fatimah',
                'email' => 'fatimah@gmail.com',
                'password' => Hash::make('fatimah123'),
                'siswa_nis' => '2023002',
                'hubungan' => 'Ibu',
                'no_hp' => '081234567892',
            ],
            [
                'name' => 'Drs. Agus Salim, M.M.',
                'email' => 'agussalim@gmail.com',
                'password' => Hash::make('agus123'),
                'siswa_nis' => '2023003',
                'hubungan' => 'Ayah',
                'no_hp' => '081234567893',
            ]
        ];

        foreach ($walis as $w) {
            $user = User::create([
                'name' => $w['name'],
                'email' => $w['email'],
                'password' => $w['password'],
                'role' => 'wali_siswa',
            ]);

            $siswa = Siswa::where('nis', $w['siswa_nis'])->first();

            WaliSiswa::create([
                'user_id' => $user->id,
                'siswa_id' => $siswa ? $siswa->id : 1,
                'hubungan' => $w['hubungan'],
                'no_hp' => $w['no_hp'],
            ]);
        }

        // Update Kelas with corresponding Wali Kelas ID
        $kelasA = \App\Models\Kelas::where('nama_kelas', 'VII-A')->first();
        if ($kelasA) {
            $kelasA->update(['wali_kelas_id' => 1]);
        }
        $kelasB = \App\Models\Kelas::where('nama_kelas', 'VII-B')->first();
        if ($kelasB) {
            $kelasB->update(['wali_kelas_id' => 2]);
        }
        $kelasC = \App\Models\Kelas::where('nama_kelas', 'VII-C')->first();
        if ($kelasC) {
            $kelasC->update(['wali_kelas_id' => 3]);
        }
    }
}
