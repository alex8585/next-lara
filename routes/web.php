<?php

use App\Events\FrontendMessage;
/* use App\Mail\OrderShipped; */
use App\Http\Resources\PostCollection;
use App\Jobs\ProcessPodcast;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Octane\Facades\Octane;

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
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	Route::get('/', function()
	{
            echo '1111';
	});

	Route::get('test',function(){
            echo '2222';
	});
});

Route::get('/', function () {
    /* $perPage = min(100, (int) request()->get('perPage', 5)); */

    /* $query = Category::queryFilter()->sort(); */

    /* if ($perPage > -1) { */
        /* return $query->paginate($perPage); */
    /* } */

    /* return $query->get(); */

    /* dump('1111'); */
    /* Octane::table('example')->set('uuid', [ */
    /*   'name' => 'Nuno Maduro', */
    /*   'votes' => 1000, */
    /* ]); */
    /* return 222; */
    /* FrontendMessage::dispatch(['text' => 'msg5']); */

  /* $query = Post::search('VERY deeply')->raw(); */

  /* return response()->json([ */
  /*   'posts' => $query, */
  /* ]); */
  /* return new PostCollection($query); */
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

require __DIR__.'/auth.php';
