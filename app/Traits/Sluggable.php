<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::creating(function ($model) {
            $prefix = $model->parent ? $model->parent->slug . ' ' : '';
            $model->slug = Str::slug($prefix . $model->name);
        });

        static::updating(function ($model) {
            $prefix = $model->parent ? $model->parent->slug . ' ' : '';
            $model->slug = Str::slug($prefix . $model->name);
        });
    }
}
