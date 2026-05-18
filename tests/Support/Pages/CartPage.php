<?php

use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . '/BasePage.php';

class CartPage extends BasePage
{
    public function open()
    {
        $this->driver->get($this->baseUrl . '/cart');
    }

    public function hasItems()
    {
        return count(
            $this->finds('.cart-row')
        ) > 0;
    }

    public function checkout()
    {
        $buttons = $this->finds('button.checkout-btn');

        if (count($buttons) > 0) {
            $buttons[0]->click();
        }
    }

    public function removeFirstItem()
    {
        $buttons = $this->finds('a.remove');

        if (count($buttons) > 0) {
            $buttons[0]->click();
        }
    }
}