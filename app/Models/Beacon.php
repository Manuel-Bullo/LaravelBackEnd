<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beacon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'lat',
        'lng',
        'rotation',
        'icon',
        'mtl',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Beacon $beacon) {
            Storage::disk('public')->delete($beacon->icon);
            Storage::disk('public')->delete($beacon->mtl);
        });
    }
}
