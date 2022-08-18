<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use App\Facades\TimeConverter as Tc;

class Timestamp implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */

    public function __construct($format = 'Y-m-d h:i:s')
    {
        $this->format = $format;
    }

    public function get($model, $key, $value, $attributes)
    {
        return Carbon::parse($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }

    public function serialize($model, string $key, $value, array $attributes)
    {
        $timestamp = Tc::strToTimestamp($value);
        $carbon = Carbon::parse($timestamp);
        return (string) $carbon->format($this->format);
    }
}
