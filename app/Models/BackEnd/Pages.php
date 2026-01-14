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
        'type',
        'parent_id',
        'active',
        'sort_order',
    ];  

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}
