<?php

namespace App\Traits;

use App\Bag\BanglaDatetimeFormatter;
use BanglaDatetimeFormat\Types\DateTime as EnDateTime;

trait CanbeBanglaDatetime
{
    public function getFormattedDatetimeAttribute()
    {
        if ($this->created_at->diffInDays(now()) >= 1) {
            return (new EnDateTime($this->created_at))->format('l jS F Y h:i:s A');
        }

        return BanglaDatetimeFormatter::en_human_time_to_bn($this->created_at->diffForHumans());
    }

    public function getHumansDatetimeAttribute()
    {
        return BanglaDatetimeFormatter::en_human_time_to_bn($this->created_at->diffForHumans());
    }
}