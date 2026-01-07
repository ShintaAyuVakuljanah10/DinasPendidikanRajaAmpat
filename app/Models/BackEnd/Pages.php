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
        'type',
        'parent',
        'meta_title',
        'meta_keywords',
        'active',
        'created_by',
        'updated_by',
        'with_content',
        'with_direct_link',
        'link',
        'order',
        'created_at',
        'updated_at',
    ];

    public function data($type = null, $active = null)
    {
        $query = DB::table('pages as p')
            ->leftJoin('pages as p2', 'p.parent', '=', 'p2.id')
            ->select('p.*', 'p2.title as parent_name')
            ->orderBy('p.order')
            ->orderBy('p.id');

        if (!is_null($type)) {
            $query->where('p.type', $type);
        }

        if (!is_null($active)) {
            $query->where('p.active', $active);
        }

        return $query->get();
    }

    public function reorder($request): bool
    {
        $id = $request->id;
        $type = $request->type;

        try {
            DB::transaction(function () use ($id, $type) {
                if ($type === 'up') {
                    DB::table('pages')->where('id', $id)->decrement('order');
                } elseif ($type === 'down') {
                    DB::table('pages')->where('id', $id)->increment('order');
                }
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
