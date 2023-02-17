<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class TimeConverter
{
    public function toTimezone($time)
    {
        if (! $time) {
            return null;
        }

        return $time
            ->setTimezone(env('FRONTEND_TIMZONE', 'Europe/Kiev'))
            ->toDateTimeString();
    }

    public function toTimestamp($datetime)
    {
        if (! $datetime) {
            return null;
        }

        return Carbon::parse($datetime)->timestamp;
    }

    public function strToTimestamp($datetime)
    {
        return $this->toTimestamp($this->toTimezone(Carbon::parse($datetime)));
    }
}
