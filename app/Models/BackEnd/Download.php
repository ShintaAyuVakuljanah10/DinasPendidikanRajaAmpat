<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
       'title','jenjang','file','page_id'
    ];

    public function getExtensionAttribute()
    {
        return strtoupper(pathinfo($this->file, PATHINFO_EXTENSION));
    }

    public function getSizeAttribute()
    {
        $path = storage_path('app/public/'.$this->file);
        return file_exists($path)
            ? round(filesize($path) / 1024 / 1024, 2)
            : 0;
    }
}
