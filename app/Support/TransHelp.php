<?php
namespace App\Support;


class TransHelp
{
  public function getValidatorFields($fields)
  {

    $validatorData = []; 
    $locales = app()->make('Astrotomic\Translatable\Locales')->all();
    foreach($fields as $field=>$value) {
        foreach($locales as $locale) {
            $validatorData["{$locale}_{$field}"] = $value;
        }
    }
    return $validatorData;
  }

}
