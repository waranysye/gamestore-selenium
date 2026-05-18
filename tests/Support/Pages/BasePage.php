<?php

use Facebook\WebDriver\WebDriverBy;

class BasePage
{
    protected $driver;
    protected $baseUrl;

    public function __construct($driver, $baseUrl)
    {
        $this->driver = $driver;
        $this->baseUrl = $baseUrl;
    }

    protected function find($selector)
    {
        return $this->driver->findElement(
            WebDriverBy::cssSelector($selector)
        );
    }

    protected function finds($selector)
    {
        return $this->driver->findElements(
            WebDriverBy::cssSelector($selector)
        );
    }

    public function currentUrl()
    {
        return $this->driver->getCurrentURL();
    }
}