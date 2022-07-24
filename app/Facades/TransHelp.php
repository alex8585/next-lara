<?php
namespace App\Facades;

use Barryvdh\Debugbar\Facade;
use App\Support\TransHelp as Th;
class TransHelp extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return Th::class;
  }
}
