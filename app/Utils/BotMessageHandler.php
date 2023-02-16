<?php

namespace App\Utils;

use App\Utils\Bot;
use App\Models\Shop;
use App\Models\Coupon;
use App\Models\Source;
use App\Utils\Paginator;
#use App\Utils\UrlConverter;
use Illuminate\Support\Str;

class BotMessageHandler
{
    // $html = "<b>bold</b>, <strong>bold</strong>
    // <i>italic</i>, <em>italic</em>
    // <a href=''>inline URL</a>
    // <code>inline fixed-width code</code>
    // <pre>pre-formatted fixed-width code block</pre>";

    public function __construct($user = null)
    {
        $this->bot = new Bot();
        $this->paginator = new Paginator();
        $this->url = new UrlConverter();
        $this->user = $user;
    }

    public function mainMenuKeybord()
    {
        $setIdCallback['action'] = 'setUserId';
        $test['action'] = 'test';
        return [
            ['text' => 'Set ID', 'callback_data' => http_build_query($setIdCallback)],
            ['text' => 'Test', 'callback_data' => http_build_query($test)],
        ];
    }

    public function setUserId($chatid, $params)
    {
        $this->bot->sendMsg($chatid, 'Input password!');
    }

    public function mainMenu($chatid)
    {
        $txt = "Menu";
        $keyboardArr = $this->mainMenuKeybord();
        $this->bot->sendMenu($chatid, $keyboardArr, $txt);
    }
}
