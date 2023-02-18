<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\Notification;
use App\Repositories\NotificationRepository;

class binanceUpdateHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function getDbNotifications()
    {
        $this->notifications = $this->notifRepo->all()->mapWithKeys(function ($notif) {
            return [$notif->symbol => [
                'symbol' => $notif->symbol,
                'price' => $notif->price,
                'direction' => $notif->direction,
            ]];
        });
        $this->notifSymbols = $this->notifications->pluck('symbol');
    }

    public function handle(NotificationRepository $notifRepo)
    {
        $this->notifRepo = $notifRepo;
        $this->getDbNotifications();

        /* dump($this->notifSymbols); */
        /* dd($this->notifications); */

        $api = new \Binance\API();
        $api->ticker(false, function ($api, $symbol, $ticker) {
            $symbol = $ticker['symbol'];
            if ($this->notifSymbols->contains($symbol)) {
                $notif = $this->notifications[$symbol];
                /* dump($notif); */

                if ($notif['direction'] == 0) {
                    if ($notif['price'] < $ticker['bestBid']) {
                        dump($symbol);
                    }
                } else {
                    if ($notif['price'] > $ticker['bestAsk']) {
                        dump($symbol);
                    }
                }
            }

            /* dump($ticker); */
        });

        return 0;
    }
}
