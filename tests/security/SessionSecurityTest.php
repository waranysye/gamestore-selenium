<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class SessionSecurityTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testNoSessionCannotAccessCart()
    {
        $this->get('/cart')
            ->assertRedirect('/login');
    }

    public function testFakeSessionWithoutUserIdIsRejected()
    {
        $this->withSession([
            'role' => 'admin'
        ])->get('/admin')
          ->assertRedirect('/login');
    }

    public function testValidSessionCanAccessCart()
{
    $result = $this->withSession([
        'user_id' => 1,
        'role' => 'user',
        'isLoggedIn' => true
    ])->get('/cart');

    $this->assertNotEquals(302, $result->response()->getStatusCode());
}
}