<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthorizationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testUserCannotAccessAdmin()
    {
        $this->withSession([
            'user_id' => 2,
            'role' => 'user'
        ])->get('/admin/users')
          ->assertRedirect('/');
    }

    public function testAdminCanAccessAdmin()
{
    $result = $this->withSession([
        'user_id' => 1,
        'role' => 'admin',
        'isLoggedIn' => true
    ])->get('/admin/users');

    $this->assertNotEquals(302, $result->response()->getStatusCode());
}
}