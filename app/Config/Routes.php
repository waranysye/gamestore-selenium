<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =========================
// PUBLIC STORE (NO LOGIN)
// =========================
$routes->get('/', 'User\Store::index');
$routes->get('search', 'User\Store::search');

// 🔥 DETAIL GAME HARUS PUBLIC (INI FIX UTAMA KAMU)
$routes->get('game/(:num)', 'User\Store::detail/$1');


// =========================
// USER AREA (LOGIN REQUIRED)
// =========================
$routes->group('', ['filter' => 'auth'], function($routes){

    // CART
    $routes->get('cart', 'User\Cart::index');
    $routes->post('cart/add/(:num)', 'User\Cart::add/$1');
    $routes->get('cart/remove/(:num)', 'User\Cart::remove/$1');

    // LIBRARY
    $routes->get('library', 'User\Library::index');
    $routes->post('library/download/(:num)', 'User\Library::download/$1');
    $routes->post('library/uninstall/(:num)', 'User\Library::uninstall/$1');

    // TRANSACTIONS / ORDERS
    $routes->get('transactions', 'User\Order::index');
    $routes->get('orders', 'User\Order::index');
    $routes->get('orders/(:num)', 'User\Order::detail/$1');

    // PROFILE
    $routes->get('profile', 'User\Profile::index');
    $routes->post('profile/update', 'User\Profile::update');
    $routes->post('profile/remove-photo', 'User\Profile::removePhoto');

    // CHECKOUT
    $routes->get('checkout', 'User\Checkout::index');
    $routes->post('checkout/buyNow', 'User\Checkout::buyNow');
    $routes->post('checkout/confirm', 'User\Checkout::confirm');

    // PAYMENT
    $routes->get('payment/status/(:num)', 'User\Checkout::status/$1');
    $routes->get('payment/(:num)', 'User\Payment::pay/$1');
    $routes->post('payment/callback', 'User\Payment::callback');
    $routes->post('payment/success/(:num)', 'User\Payment::success/$1');
    $routes->post('payment/cancel/(:num)', 'User\Checkout::cancel/$1');

    // DOWNLOAD
    $routes->get('download/game/(:num)', 'User\Download::game/$1');

});


// =========================
// ADMIN AREA (LOGIN + ROLE ADMIN)
// =========================
$routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], function($routes) {

    $routes->get('/', 'UserController::index');

    // USERS
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');

    // CATEGORIES
    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/create', 'CategoryController::create');
    $routes->post('categories/store', 'CategoryController::store');
    $routes->get('categories/edit/(:num)', 'CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1');
    $routes->get('categories/delete/(:num)', 'CategoryController::delete/$1');

    // GAMES
    $routes->get('games', 'GameController::index');
    $routes->get('games/create', 'GameController::new');
    $routes->post('games', 'GameController::create');
    $routes->get('games/edit/(:num)', 'GameController::edit/$1');
    $routes->post('games/update/(:num)', 'GameController::update/$1');
    $routes->post('games/delete/(:num)', 'GameController::delete/$1');

    // ORDERS
    $routes->get('orders', 'OrderController::index');
    $routes->post('orders/approve/(:num)', 'OrderController::approve/$1');
    $routes->post('orders/reject/(:num)', 'OrderController::reject/$1');
});


// =========================
// AUTH
// =========================
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');

$routes->get('/signup', 'Auth::signup');
$routes->post('/signup', 'Auth::attemptSignup');

$routes->get('/logout', 'Auth::logout');


// =========================
// API (UNTUK FLUTTER)
// =========================
// =========================
// API (UNTUK FLUTTER)
// =========================
$routes->group('api', ['filter' => 'cors'], function($routes) {
    
    // --- PUBLIC API ---
    $routes->post('login', 'Api\Auth::login');
    $routes->post('register', 'Api\Auth::register');
    $routes->get('games', 'Api\Game::index');
    $routes->get('games/(:num)', 'Api\Game::show/$1');

    // --- PROTECTED USER API (Butuh Token) ---
    $routes->group('', ['filter' => 'authApi'], function($routes) { 
        // Cart
        $routes->get('cart', 'Api\Cart::index');
        $routes->post('cart/add/(:num)', 'Api\Cart::add/$1');
        $routes->delete('cart/remove/(:num)', 'Api\Cart::remove/$1');
        
        // Library & Profile
        $routes->get('library', 'Api\Library::index');
        $routes->get('profile', 'Api\Profile::index');
        $routes->post('profile/update', 'Api\Profile::update');
        
        // Checkout & Orders
        $routes->post('checkout', 'Api\Checkout::store');
        $routes->get('orders', 'Api\Order::index');
    });

    // --- PROTECTED ADMIN API (Butuh Token + Role Admin) ---
    // Pastikan kamu punya filter 'adminApi' atau gabungan 'authApi','admin'
    $routes->group('admin', ['filter' => 'adminApi'], function($routes) {
        $routes->get('games', 'Api\Admin\Game::index');
        $routes->post('games', 'Api\Admin\Game::store');
    });
});