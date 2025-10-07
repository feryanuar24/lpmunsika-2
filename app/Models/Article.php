<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'is_active',
        'is_pinned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail) {
            return null;
        }

        $disk = config('filesystems.default');


        if ($disk === 'public') {
            return asset('storage/' . $this->thumbnail);
        }

        if ($disk === 'local') {
            return route('files', ['path' => $this->thumbnail]);
        }

        $diskConfig = config("filesystems.disks.{$disk}");
        if (isset($diskConfig['url'])) {
            return rtrim($diskConfig['url'], '/') . '/' . $this->thumbnail;
        }

        return $this->thumbnail;
    }
}
