<?php

namespace Tests\Browser\Traits;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Laravel\Dusk\Browser;

trait TestsUtils
{
  protected function login($browser)
  {
    $browser
      ->visit('/login')
      ->type('[type=email]', 'blyakher85@gmail.com')
      ->type('[type=password]', 'password')
      ->press('.q-btn__content')
      ->waitForText('Admin');
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

  protected function waitPresent($elemPath)
  {
    $this->browse(function (Browser $browser) use ($elemPath) {
      $driver = $browser->driver;
      $driver
        ->wait()
        ->until(
          WebDriverExpectedCondition::presenceOfElementLocated(
            WebDriverBy::xpath($elemPath)
          )
        );
      $driver
        ->wait()
        ->until(
          WebDriverExpectedCondition::visibilityOfElementLocated(
            WebDriverBy::xpath($elemPath)
          )
        );
    });
  }

  protected function waitNotPresent($elemPath)
  {
    $this->browse(function (Browser $browser) use ($elemPath) {
      $driver = $browser->driver;

      $driver
        ->wait()
        ->until(
          WebDriverExpectedCondition::not(
            WebDriverExpectedCondition::presenceOfElementLocated(
              WebDriverBy::xpath($elemPath)
            )
          )
        );
    });
  }

  protected function getElem($elementXpath)
  {
    $elem = null;

    $this->browse(function (Browser $browser) use ($elementXpath, &$elem) {
      $driver = $browser->driver;
      $this->waitPresent($elementXpath);

      $elem = $driver->findElement(WebDriverBy::xpath($elementXpath));
    });

    return $elem;
  }

  protected function elemClick($browser, $elementXpath)
  {
    $driver = $browser->driver;

    $elem = $this->getElem($elementXpath);
    $driver->wait()->until(function () use ($elem) {
      try {
        /* $driver->executeScript('console.log("clicking");'); */
        $elem->click();
      } catch (WebDriverException $e) {
        return false;
      }
      /* $driver->executeScript('console.log("clickable");'); */

      return true;
    });
  }
}
