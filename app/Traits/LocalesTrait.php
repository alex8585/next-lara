<?php

namespace App\Traits;

trait LocalesTrait
{
    private static $locales;
    public static function getAllLocales()
    {
        if (! self::$locales) {
            self::$locales = app()->make('Astrotomic\Translatable\Locales')->all();
        }
        return self::$locales;
    }

    public function formatLocalesFields($fields)
    {
        $locales = self::getAllLocales();
        $data = [];
        foreach ($fields as $field=>$value) {
            $parts = explode("_", $field);
            if (in_array($parts[0], $locales)) {
                $locale = $parts[0];
                $trField = str_replace("{$locale}_", "", $field);
                $data[$locale][$trField] = $value;
            } else {
                $data[$field] = $value;
            }
        }
        return $data;
    }
}
