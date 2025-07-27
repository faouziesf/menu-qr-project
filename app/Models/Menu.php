<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'template',
        'content',
        'file_path',
        'qr_code_path',
        'is_published'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($menu) {
            if (empty($menu->slug)) {
                $menu->slug = Str::slug($menu->name . '-' . uniqid());
            }
        });
    }

    public function getPublicUrlAttribute()
    {
        return url("/menu/{$this->slug}");
    }
}