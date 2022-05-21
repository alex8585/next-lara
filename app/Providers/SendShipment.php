<?php

namespace App\Providers;

use App\Providers\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendShipment
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
     * @param  \App\Providers\OrderShipped  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
        //
    }
}
