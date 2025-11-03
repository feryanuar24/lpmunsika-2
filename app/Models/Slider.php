<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'banner', 'description'];

    public function getUrlAttribute()
    {
        if (!$this->banner) {
            return null;
        }

        $disk = config('filesystems.default');


        if ($disk === 'public') {
            return asset('storage/' . $this->banner);
        }

        if ($disk === 'local') {
            return route('files', ['path' => $this->banner]);
        }

        $diskConfig = config("filesystems.disks.{$disk}");
        if (isset($diskConfig['url'])) {
            return rtrim($diskConfig['url'], '/') . '/' . $this->banner;
        }

        return $this->banner;
    }
}
