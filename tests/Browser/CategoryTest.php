<?php

namespace Tests\Browser;

use Database\Seeders\CategorySeeder;
use Database\Seeders\UserSeeder;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestsUtils;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
  use DatabaseMigrations;
  use TestsUtils;

  private $url = '/categories';

  public function setUp(): void
  {
    parent::setUp();
    $this->seed([UserSeeder::class, CategorySeeder::class]);
  }

  /**
   * A Dusk test example.
   */
  public function testIndex()
  {
    $this->browse(function (Browser $browser) {
      $this->login($browser);

      $browser->visit($this->url)->waitForText('Categories');
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
      $browser->visit($this->url)->waitForText('Categories');

      $driver = $browser->driver;

      $elemPath = '//*[@id="app"]/div/div[2]/main/div/div[1]/div[2]/button';
      $this->elemClick($browser, $elemPath);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->elemClick($browser, $elemPath);

      $catName = 'test-cat-name';
      $browser->type('name', $catName);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]/span[2]/span';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);
      // $browser->pause(1000);

      $this->assertDatabaseCount('categories', 6);
      $this->assertDatabaseHas('categories', [
        'name' => $catName,
      ]);
    });
  }

  public function testUpdate()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)->waitForText('Categories');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[1]';
      $this->elemClick($browser, $elemPath);

      $catName = 'new-cat-name';

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->waitPresent($elemPath);

      $oldCatName = $browser->inputValue('name');
      $browser->type('name', $catName);
      $newCatName = $oldCatName . $catName;

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);

      $this->assertDatabaseHas('categories', [
        'name' => $newCatName,
      ]);

      /* $browser->pause(5000); */
    });
  }

  public function testDelete()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)->waitForText('Categories');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[2]';

      $catName = $this->getElem($elemPath)->getText();

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[2]/button[2]';

      $this->elemClick($browser, $elemPath);

      $this->waitNotPresent($elemPath);

      $this->assertDatabaseMissing('categories', [
        'name' => $catName,
      ]);
      $this->assertDatabaseCount('categories', 4);
    });
  }
}
