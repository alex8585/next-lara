<?php

namespace Tests\Browser;

use Database\Seeders\TagSeeder;
use Database\Seeders\UserSeeder;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\TestsUtils;
use Tests\DuskTestCase;

class TagTest extends DuskTestCase
{
  use DatabaseMigrations;
  use TestsUtils;

  public function setUp(): void
  {
    parent::setUp();
    $this->seed([UserSeeder::class, TagSeeder::class]);
  }

  /**
   * A Dusk test example.
   */
  public function testIndex()
  {
    $this->browse(function (Browser $browser) {
      $this->login($browser);

      $browser->visit('/apptags')->waitForText('Tags');
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
      $browser->visit('/apptags')->waitForText('Tags');

      $driver = $browser->driver;

      $elemPath = '//*[@id="app"]/div/div[2]/main/div/div[1]/div[2]/button';
      $this->elemClick($browser, $elemPath);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->elemClick($browser, $elemPath);

      $tagName = 'test-tag-name';
      $browser->type('name', $tagName);

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]/span[2]/span';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);
      // $browser->pause(1000);

      $this->assertDatabaseCount('tags', 6);

      $this->assertDatabaseHas('tags', [
        'name' => $tagName,
      ]);
    });
  }

  public function testUpdate()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit('/apptags')->waitForText('Tags');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[1]';
      $this->elemClick($browser, $elemPath);

      $tagName = 'new-tag-name';

      $elemPath =
        '/html/body/div[2]/div/div[2]/div/div[2]/form/div/div/div/label/div/div[1]/div/input';
      $this->waitPresent($elemPath);

      $oldTagName = $browser->inputValue('name');
      $browser->type('name', $tagName);
      $newTagName = $oldTagName . $tagName;

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[3]/div/button[2]';
      $this->waitNotPresent($elemPath);

      $this->assertDatabaseHas('tags', [
        'name' => $newTagName,
      ]);

      /* $browser->pause(5000); */
    });
  }

  public function testDelete()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit('/apptags')->waitForText('Tags');

      $driver = $browser->driver;

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[2]';

      $tagName = $this->getElem($elemPath)->getText();

      $elemPath =
        '/html/body/div/div/div[2]/main/div/div[2]/div[2]/table/tbody/tr[1]/td[3]/button[2]';

      $this->elemClick($browser, $elemPath);

      $elemPath = '/html/body/div[2]/div/div[2]/div/div[2]/button[2]';

      $this->elemClick($browser, $elemPath);

      $this->waitNotPresent($elemPath);

      $this->assertDatabaseMissing('tags', [
        'name' => $tagName,
      ]);
      $this->assertDatabaseCount('tags', 4);
    });
  }
}
