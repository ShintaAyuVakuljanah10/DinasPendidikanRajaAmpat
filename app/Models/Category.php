<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['nama', 'slug'];
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->nama);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->nama);
        });
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'kategori_id');
    }
}
