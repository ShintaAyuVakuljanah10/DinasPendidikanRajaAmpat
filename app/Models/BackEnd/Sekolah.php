<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'status',
        'kecamatan',
        'desa',
        'alamat',
        'latitude',
        'longitude',
        'jumlah_guru',
        'jumlah_siswa',
        'jumlah_fasilitas'
    ];
}
