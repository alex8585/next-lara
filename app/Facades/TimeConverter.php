<?php
namespace App\Facades;

use Barryvdh\Debugbar\Facade;
use App\Support\TimeConverter as Tc;
class TimeConverter extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return Tc::class;
  }
}
