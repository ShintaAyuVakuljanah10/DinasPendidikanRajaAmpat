<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'type',
        'handler',
        'parent_id',
        'active',
        'sort_order',
    ];  

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('active', 1)
            ->orderBy('sort_order', 'asc');
    }   
}
