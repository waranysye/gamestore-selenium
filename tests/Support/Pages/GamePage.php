<?php

use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . '/BasePage.php';

class GamePage extends BasePage
{
    public function open($id = 2)
    {
        $this->driver->get($this->baseUrl . '/game/' . $id);
    }

    public function addToCart()
    {
        $buttons = $this->finds('#addToCartForm button');

        if (count($buttons) > 0) {
            $buttons[0]->click();
        }
    }

    public function buyNow()
    {
        $buttons = $this->finds('#buyNowForm button');

        if (count($buttons) > 0) {
            $buttons[0]->click();
        }
    }

    public function alreadyInCart()
    {
        return count(
            $this->finds('button[disabled]')
        ) > 0;
    }

    public function canAddToCart()
    {
        return count(
            $this->finds('#addToCartForm button')
        ) > 0;
    }
}