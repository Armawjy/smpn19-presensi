<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas_id',
        'no_hp',
        'alamat',
        'agama',
        'jenis_kelamin',
        'qr_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function waliSiswa()
    {
        return $this->hasOne(WaliSiswa::class, 'siswa_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }
}
