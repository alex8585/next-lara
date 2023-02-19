<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

    /* public $lastNotifsReadTime = null; */

    public function reloadNotifications()
    {
        $this->notifications = Cache::remember('notifications', 30, function () {
            dump('load');
            return $this->notifRepo->all()->filter(function ($value, $key) {
                return $value['sent'] == 0;
            });
            ;
        });

        $this->notifSymbols = $this->notifications->pluck('symbol');
    }

    public function reloadNotifications2()
    {
        /* if ( */
        /*     !isset($this->lastNotifsReadTime) */
        /*     || $this->lastNotifsReadTime < now()->subMinutes(1) */
        /* ) { */
        /*     Cache::forget('notifications'); */
        /*     $this->lastNotifsReadTime = now(); */
        /* } */

        if (! Cache::has('notifications') || ! isset($this->notifications)) {
            $this->getDbNotifications();
            /* $this->lastNotifsReadTime = now(); */
        }
    }

    public function sendTgMsg($msg)
    {
        $apiToken = config('telegram.bots.mybot.token');
        $chatId = Cache::get("telegram_chat_id");

        $data = [
            'chat_id' => $chatId,
            'text' => $msg
        ];

        $response = Http::get("https://api.telegram.org/bot$apiToken/sendMessage?" .
            http_build_query($data));
    }

    public function notificationHandle($notif)
    {
        $symbol = $notif['symbol'];
        $notif->sent = 1;
        $notif->save();
        Cache::forget('notifications');
        dump($symbol);

        $direction = $notif['direction'] ? ' < ' : ' > ';
        $this->sendTgMsg($symbol . $direction . $notif['price']);
    }

    public function handle(NotificationRepository $notifRepo)
    {
        $this->notifRepo = $notifRepo;

        $api = new \Binance\API();
        $api->ticker(false, function ($api, $symbol, $ticker) {
            $this->reloadNotifications();

            $symbol = $ticker['symbol'];
            if (! $this->notifSymbols->contains($symbol)) {
                return;
            }
            $notif = $this->notifications->firstWhere('symbol', $symbol);

            if ($notif->sent) {
                return;
            }

            if ($notif['direction'] == 0) {
                if ($notif['price'] < $ticker['bestBid']) {
                    $this->notificationHandle($notif);
                }
            } else {
                if ($notif['price'] > $ticker['bestAsk']) {
                    $this->notificationHandle($notif);
                }
            }
        });

        return 0;
    }
}
