<?php

use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . '/BasePage.php';

class LoginPage extends BasePage
{
    public function open()
    {
        $this->driver->get($this->baseUrl . '/login');
    }

    public function login($email = 'dash@gmail.com', $password = 'dash123')
    {
        $this->open();

        $this->find('input[name=email]')
            ->clear()
            ->sendKeys($email);

        $this->find('input[name=password]')
            ->clear()
            ->sendKeys($password);

        $this->find('button[type=submit]')->click();
    }

    public function isLoggedIn()
    {
        return strpos($this->currentUrl(), '/login') === false;
    }
}