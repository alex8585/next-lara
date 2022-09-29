<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mod;
use App\Models\Time;

class Hello extends Command
{
    /* public function getSubscribedSignals(): array */
    /* { */
    /*     return [SIGINT, SIGTERM]; */
    /* } */

    /* public function handleSignal(int $signal): void */
    /* { */
    /*     if ($signal === SIGINT) { */

    /*     $this->error('SIGINT'); */
    /*         return; */
    /*     } */
    /* } */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello';

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
    public function handle()
    {
        $now = now();
        Time::insert([
          'created_at' => $now,
          'updated_at' => $now,
          'Tz' => $now,
          'added_at' => $now,
        ]);
        /* $t = Time::find(6); */
        /* $t2 = Time::find(7); */
        /* dump($t->created_at->timestamp); */
        /* dump($t2->Tz->timestamp); */
        /* dump($t->created_at); */

        /* dump($t->Tz); */

        /* $p = Post::find(1) */
        /*   ->lockForUpdate() */
        /*   ->first(); */
        /* dump($p->title); */
        /* $p->title = '21bbb'; */
        /* dump($p->title); */
        /* $p->save(); */
        /* dd($p->title); */

        /* Log::info('aaabbccc'); */
        /* sleep(30); */
        /* echo '7777777777888888888'; */
        /* $executed = RateLimiter::attempt( */
        /*   'send-message:', */
        /*   $perMinute = 5, */
        /*   function () { */
        /*     // Send message... */
        /*     echo 'aaaa'; */
        /*     return 5; */
        /*   } */
        /* ); */

        /* dump($executed); */
        /* /1* dd(RateLimiter::tooManyAttempts('send-message:', $perMinute = 5)); *1/ */
        /* $seconds = RateLimiter::availableIn('send-message:'); */

        /* dump($seconds); */

        /* $now = now(); */
        /* $today = today(); /1* $slice = Str::of('This is my name')->after('aaaaaa'); *1/ */
        /* dd($now, $today); */
        /* Mail::to('blyakher85@gmail.com')->send(new OrderShipped()); */
        /* echo (new OrderShipped())->render(); */
        /* echo trans_choice('auth.apples', 0); */
        /* Http::dd()->get('http://example.com'); */
        /* $a = str('1111')->toString(); */
        /* $a = str('Taylor')->append(' Otwell'); */
        /* $string = str('/foo/bar/baz.jpg')->basename('.jpg'); */
        /* $string = Str::of('foo bar baz')->explode(' '); */
        /* $adjusted = Str::of('this/string')->finish('/'); */
        /* $url = secure_url('user/profile', [1]); */
        /* dd($url); */
        /* echo 'a'; */
        /* Cache::lock('foo')->block(11, function () { */
        /*   sleep(15); */
        /*   echo '1111111'; */
        /* }); */
        /* echo 'b'; */

        /* $value = Cache::remember('foo', 1000, function () { */
        /*     return '9999' ; */
        /* }); */
        /* dd($value); */
        /* $this->info('Something went wrong!'); */
        /* sleep(10); */
        return 0;
    }
}
