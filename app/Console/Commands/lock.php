<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class lock extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'lock';

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
    DB::transaction(function () {
      $p = Post::find(1)
        ->lockForUpdate()
        ->first();
      sleep(30);
      $p->title = 'AAAAAAAAAAAAAAAAAAAAAAAA';
      $p->save();
      dump($p->title);
    });
    return 0;
  }
}
