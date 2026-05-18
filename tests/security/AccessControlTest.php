<?php

namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AccessControlTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testGuestCannotAccessCart()
    {
        $this->get('/cart')
            ->assertRedirect('/login');
    }

    public function testGuestCannotAccessCheckout()
    {
        $this->get('/checkout')
            ->assertRedirect('/login');
    }

    public function testGuestCannotAccessLibrary()
    {
        $this->get('/library')
            ->assertRedirect('/login');
    }

    // ... (kode lama tetap) ...

    public function testGuestCannotAccessAdminGames() {
        $this->get('/admin/games')->assertRedirect('/login');
    }

    public function testGuestCannotAccessAdminCategories() {
        $this->get('/admin/categories')->assertRedirect('/login');
    }

    public function testGuestCannotAccessAdminUsers() {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function testGuestCannotAccessAdminOrders() {
        $this->get('/admin/orders')->assertRedirect('/login');
    }

    public function testCustomerCannotAccessAdminGames() {
        // Simulasi Login sebagai user biasa
        $session = ['user_id' => 2, 'role' => 'customer', 'isLoggedIn' => true];
        $this->withSession($session)->get('/admin/games')->assertRedirect('/login'); 
        // Note: assertStatus disesuaikan, jika ditarik ke login maka ->assertRedirect('/login')
    }
}