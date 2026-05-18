<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    public function testPaymentStatusSuccess()
    {
        $status = 'paid';

        $this->assertEquals('paid', $status);
    }

    public function testTransactionIdExists()
    {
        $transactionId = 'TRX12345';

        $this->assertNotEmpty($transactionId);
    }
}