<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'snippet_id',
        'title',
        'uuid',
        'body',
        'order'
    ];

    public static function booted()
    {
        static::creating(function (Model $model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * snippet
     *
     * @return void
     */
    /**
     * snippet
     *
     * @return void
     */
    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }

    /**
     * afterOrder
     *
     * @return void
     */
    public function afterOrder()
    {
        $adjacent = self::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if (!$adjacent) {
            return self::orderBy('order', 'desc')->first()->order + 1;
        }

        return ($this->order + $adjacent->order) / 2;
    }

    /**
     * beforeOrder
     *
     * @return void
     */
    public function beforeOrder()
    {
        $adjacent = self::where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if (!$adjacent) {
            return self::orderBy('order', 'asc')->first()->order - 1;
        }

        return ($this->order + $adjacent->order) / 2;
    }
}
