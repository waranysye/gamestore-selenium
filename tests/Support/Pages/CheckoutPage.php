<?php

use Facebook\WebDriver\WebDriverBy;

require_once __DIR__ . '/BasePage.php';

class CheckoutPage extends BasePage
{
    public function confirmPayment()
    {
        $buttons = $this->finds('button[type=submit]');

        if (count($buttons) > 0) {
            $buttons[0]->click();
        }
    }

    public function chooseBankTransfer()
    {
        $methods = $this->finds('.method');

        if (count($methods) > 0) {
            $methods[0]->click();
        }
    }

    public function chooseEwallet()
    {
        $methods = $this->finds('.method');

        if (count($methods) > 1) {
            $methods[1]->click();
        }
    }

    public function isOpened()
    {
        return strpos($this->currentUrl(), '/checkout') !== false;
    }

    public function isPaymentStatus()
    {
        return strpos($this->currentUrl(), '/payment/status') !== false;
    }
}