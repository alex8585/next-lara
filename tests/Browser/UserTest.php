<?php

namespace Tests\Browser;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestsUtils;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
  use DatabaseMigrations;
  use TestsUtils;

  private $url = '/users';

  public function setUp(): void
  {
    parent::setUp();
    $this->seed([UserSeeder::class]);
    User::factory()
      ->count(4)
      ->create(['role' => 'user']);
  }

  /**
   * A Dusk test example.
   */
  public function testIndex()
  {
    $this->browse(function (Browser $browser) {
      $this->login($browser);

      $browser->visit($this->url)->waitForText('Users');
      $text = $browser->driver
        ->findElement(
          WebDriverBy::xpath(
            '//*[@id="app"]/div/div[2]/main/div/div[2]/div[3]/div[3]/span'
          )
        )
        ->getText();
      $this->assertEquals($text, '1-5 of 5');
      // $browser->pause(141000);
    });
  }

  public function testCreate()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)->waitForText('Users');

      $driver = $browser->driver;

      $elemPath = '//*[@id="app"]/div/div[2]/main/div/div[1]/div[2]/button';
      $this->elemClick($browser, $elemPath);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->elemClick($browser, $elemPath);

      $name = 'test-name';
      $email = 'test-name@gmail.com';
      $password = 'test-password';
      $browser->type('name', $name);
      $browser->type('email', $email);
      $browser->type('password', $password);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]/span[2]/span';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);
      // $browser->pause(1000);

      $this->assertDatabaseCount('users', 6);
      $this->assertDatabaseHas('users', [
        'name' => $name,
        'email' => $email,
        'role' => 'user',
      ]);
    });
  }

  public function testUpdate()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)->waitForText('Users');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[1]';
      $this->elemClick($browser, $elemPath);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->waitPresent($elemPath);

      $name = 'test-name';
      $password = 'test-password';

      $oldName = $browser->inputValue('name');
      $oldEmail = $browser->inputValue('email');

      $browser->type('name', $name);
      $browser->type('password', $password);

      $newName = $oldName . $name;

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);

      $this->assertDatabaseHas('users', [
        'name' => $newName,
        'email' => $oldEmail,
        'role' => 'admin',
      ]);

      /* $browser->pause(5000); */
    });
  }

  public function testDelete()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)->waitForText('Users');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[2]';

      $name = $this->getElem($elemPath)->getText();

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[2]/button[2]';

      $this->elemClick($browser, $elemPath);

      $this->waitNotPresent($elemPath);

      $this->assertDatabaseMissing('users', [
        'name' => $name,
      ]);
      $this->assertDatabaseCount('users', 4);
    });
  }
}
