<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\MaxAttemptsExceededException;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 50;
    public $maxExceptions = 1;
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $value = (bool) random_int(0, 1);
        if ($value) {
            throw new \Exception('Division by zero.');
        }

        Log::debug('line1 ', $this->order);
        sleep(2);
        Log::debug('line2 ', $this->order);
        sleep(2);
        Log::debug('line3 ', $this->order);
    }

    public function failed(MaxAttemptsExceededException $exception)
    {
        // Send user notification of failure, etc...
    }

    public function middleware()
    {
        return [(new WithoutOverlapping('ksdfgjydasu'))->releaseAfter(5)];
    }
}
