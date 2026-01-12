<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'aplikasi';
    protected $fillable = [
        'nama_aplikasi',
        'judul_aplikasi',
        'deskripsi',
        'logo',
        'email',
        'hp',
        'alamat',
        'salam',
    ];
}
