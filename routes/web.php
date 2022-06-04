<?php

use App\Events\OrderShipped;
use App\Jobs\ProcessPodcast;
/* use App\Mail\OrderShipped; */
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  $s = Post::search("Come on!'.")->get();
  dd($s);
  /* OrderShipped::dispatch('2222'); */
  /* User::factory()->create(); */
  /* dump(Cookie::get()); */
  /* dump(csrf_token()); */
  /* dump(Session::token()); */

  /* dump( */
  /*   request() */
  /*     ->session() */
  /*     ->all() */
  /* ); */
  /* $v = Cache::get('key'); */
  /* dd($v); */
  /* return '222222'; */
  /* echo (new OrderShipped())->render(); */

  /* $path = base_path('storage'); */
  /* $singular = Str::plural('child', 2); */
  /* return $singular; */
  /* dd($path); */
  /* $a = ProcessPodcast::dispatch(['job' => 1])->onQueue('b'); */
  /* Storage::put('public/example1.txt', 'vbbb'); */
  /* $contents = Storage::get('public/example1.txt'); */
  /* return Storage::download('public/example1.txt'); */
  /* echo $contents; */
  /* Storage::prepend('public/example1.txt', 'Prepended Text'); */
  /* Storage::setVisibility('public/example1.txt', 'private'); */
  /* $visibility = Storage::getVisibility('public/example1.txt'); */
  /* Storage::makeDirectory('public/1111'); */
  /* $files = Storage::files('public'); */
  /* dd($files); */
  /* $url = Storage::url('example1.txt'); */

  /* echo $url; */
  /* echo PHP_EOL; */
  /* echo asset('storage/example1.txt'); */
});

require __DIR__ . '/auth.php';
