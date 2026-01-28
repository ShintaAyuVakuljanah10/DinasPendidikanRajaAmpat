<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Berita extends Model
{
    protected $table = 'posts';
    protected $fillable = ['kategori_id', 'judul', 'slug', 'isi', 'thumbnail'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
