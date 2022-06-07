<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Snippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'uuid',
        'is_public'
    ];

    public static function booted()
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::uuid();
        });
    }


    /**
     * isPublic
     *
     * @return void
     */
    public function isPublic()
    {
        return $this->is_public;
    }

    /**
     * scopePublic
     *
     * @param  mixed $builder
     * @return void
     */
    public function scopePublic(Builder $builder)
    {
        return $builder->where('is_public', false);
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function steps()
    {
        return $this->hasMany(Step::class)
            ->orderBy('order', 'asc');
    }
}
