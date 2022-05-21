<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
class SendShipment implements ShouldQueue
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  \App\Events\OrderShipped  $event
   * @return void
   */
  public function handle(OrderShipped $event)
  {
    sleep(5);
    Log::debug('event: ', $event->order);
  }
}
