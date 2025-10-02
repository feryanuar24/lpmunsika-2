<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Embed extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'platform_id',
        'title',
        'embed_code',
        'description',
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
