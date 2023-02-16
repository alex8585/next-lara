<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $response = Telegram::getMe();
        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        $chatId = Cache::get("telegram_chat_id");

        /* Telegram::setAsyncRequest(true) */
        /* ->sendMessage(['chat_id' => $chatId, 'text'=>'333' ]); */

        return [
            'botId' => $botId,
            'botName' => $firstName,
            'botUsername' => $username,
            'chatId' => $chatId,
        ];
    }
}
