<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use App\Events\OrderShipped;
class IndexTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_example()
  {
    Event::fake();
    $response = $this->get('/');

    $response->assertStatus(200);

    Event::assertDispatched(OrderShipped::class);
  }
}
