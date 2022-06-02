<?php

namespace Tests\Browser;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
  use DatabaseMigrations;

  /**
   * A Dusk test example.
   */
  public function testUserLogin()
  {
    $this->seed(UserSeeder::class);

    $this->browse(function (Browser $browser) {
      //  $user = User::factory()->create();

      /* dump($user); */
      $browser->visit('/login')->assertSee('Login');
      $browser
        ->type('[type=email]', 'blyakher85@gmail.com')
        ->type('[type=password]', 'password')
        ->press('.q-btn__content');
      $browser->pause(4000);
    });
  }

  protected function driver()
  {
    $options = (new ChromeOptions())->addArguments(['--disable-gpu']);

    return RemoteWebDriver::create(
      'http://localhost:9515',
      DesiredCapabilities::chrome()->setCapability(
        ChromeOptions::CAPABILITY,
        $options
      )
    );
  }
}
