<?php

namespace App\Utils;

use App\Utils\Bot;
use Telegram\Bot\Actions;
use App\Utils\UserSession;
use Illuminate\Support\Str;
use App\Utils\BotMessageHandler;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;

class UpdatesHandler
{
    public function __construct()
    {
        $this->bot = new Bot();

        $this->userSession = new UserSession();
    }

    public function commandRespond($msg)
    {
        $chatid = $msg['chat']['id'];
        //$userid = $msg['from']['id'];
        $msgText = isset($msg['text']) ? $msg['text'] : null;
        Telegram::sendChatAction(['action' => Actions::TYPING, 'chat_id' => $chatid]);
        $this->msgHandler = new BotMessageHandler();

        if (! $msgText) {
            $this->msgHandler->mainMenu($chatid);
            return;
        }

        if (Str::startsWith($msgText, '/start')) {
            $referrer = Str::replace('/start', '', $msgText);
            $msgText = '/start';
            $referrer = (string)Str::of($referrer)->trim();
            /* if ($referrer) { */
            /*     $user = $this->userSession->getDbUserByTgUser($msg['from']); */
            /*     $activity['tguser_id'] = $user['id']; */
            /*     $activity['type'] = 'referrer'; */
            /*     $activity['referrer'] = $referrer; */
            /*     $this->userSession->saveActivity($activity); */
            /* } */
        }

        if ($msgText == '/start') {
            Cache::forget("telegram_last_action_${chatid}");

            $this->msgHandler->mainMenu($chatid);
        } else {
            $action = Cache::get("telegram_last_action_${chatid}");
            switch ($action) {
                case 'setUserId':
                    $password = '1234';
                    if ($password == $msgText) {
                        dump($chatid);
                        Cache::put("telegram_chat_id", $chatid);
                        Cache::forget("telegram_last_action_${chatid}");

                        $this->bot->sendMsg($chatid, 'User id has been saved');
                    } else {
                        $this->bot->sendMsg($chatid, 'Password incorrect, try again!');
                    }
                    break;
                default:
                    $this->bot->sendMsg($chatid, 'Я не знаю такую команду');
            }
        }
    }

    public function callbackQuery($msg)
    {
        $chatid = $msg['message']['chat']['id'];
        $userid = $msg['from']['id'];
        $data = $msg['data'];

        /* $user = $this->userSession->getDbUserByTgUser($msg['from']); */
        $this->msgHandler = new BotMessageHandler();

        $params = [];
        if (strpos($data, 'action=') !== false) {
            parse_str($data, $params);
        }

        $action = isset($params['action']) ? $params['action'] : null;

        Cache::set("telegram_last_action_${chatid}", $action);

        Telegram::sendChatAction(['action' => Actions::TYPING, 'chat_id' => $chatid]);
        switch ($action) {
            case 'setUserId':
                $this->msgHandler->setUserId($chatid, $params);
                break;
            default:
                $this->bot->sendMsg($chatid, 'Я не знаю такую команду клавиатуры');
        }
    }
}
