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

// =========================
// USER AREA (LOGIN REQUIRED)
// =========================
$routes->group('', ['filter' => 'auth'], function($routes){

    $routes->get('game/(:num)', 'User\Store::detail/$1');
    $routes->get('search', 'User\Store::search');

    $routes->get('cart', 'User\Cart::index');
    $routes->post('cart/add/(:num)', 'User\Cart::add/$1');
    $routes->get('cart/remove/(:num)', 'User\Cart::remove/$1');

    $routes->get('library', 'User\Library::index');
    $routes->get('transactions', 'User\Order::index');
    $routes->get('orders', 'User\Order::index');       // ✅ TAMBAHAN
    $routes->get('profile', 'User\Profile::index');
    $routes->post('profile/update', 'User\Profile::update');
    $routes->post('profile/remove-photo', 'User\Profile::removePhoto');


    $routes->get('checkout', 'User\Checkout::index');
    $routes->post('checkout', 'User\Checkout::confirm');
    $routes->post('checkout/buyNow', 'User\Checkout::buyNow');
    $routes->post('checkout/confirm', 'User\Checkout::confirm');
    $routes->get('payment/status/(:num)', 'User\Checkout::status/$1');
    $routes->get('download/game/(:num)', 'User\Download::game/$1');
    $routes->post('payment/callback', 'User\Payment::callback');
    $routes->get('payment/(:num)', 'User\Payment::pay/$1');
    $routes->post('payment/success/(:num)', 'User\Payment::success/$1');
    $routes->post('payment/cancel/(:num)', 'User\Checkout::cancel/$1');

});

// =========================
// ADMIN AREA (LOGIN + ROLE ADMIN)
// =========================
$routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], function($routes) {
     // ✅ DEFAULT ADMIN PAGE
    $routes->get('/', 'UserController::index');
    // (nanti bisa diganti Dashboard::index)

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
$routes->get('games/create', 'GameController::new');      // FORM
$routes->post('games', 'GameController::create');        // STORE
$routes->get('games/edit/(:num)', 'GameController::edit/$1');
$routes->post('games/update/(:num)', 'GameController::update/$1');
$routes->get('games/delete/(:num)', 'GameController::delete/$1');

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