<?php

namespace App\Listeners;

use App\Events\FrontendMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendFrontendMessage implements ShouldQueue
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(FrontendMessage $event)
  {
    /* sleep(5); */
    Log::debug('event: ', $event->msg);
  }
}
