<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'nama',
        'gambar',
        'urutan'
    ];
}
