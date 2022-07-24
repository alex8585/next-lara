<?php
namespace App\Support;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Astrotomic\Translatable\Locales;

class TransHelp
{
    public function getLocales()
    {
        /* $locales =   array_keys(LaravelLocalization::getSupportedLocales()) ; */
        return app()->make('Astrotomic\Translatable\Locales')->all();
    }

    public function getValidatorFields($fields)
    {
        $validatorData = [];
        $locales = $this->getLocales();
        foreach ($fields as $field=>$value) {
            foreach ($locales as $locale) {
                $validatorData["{$locale}_{$field}"] = $value;
            }
        }
        return $validatorData;
    }
}
