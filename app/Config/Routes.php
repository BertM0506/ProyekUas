<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('/', 'Home::index');
$routes->get('/produk', 'Produk::index');
$routes->get('/produk/detail/(:num)', 'Produk::detail/$1');

$routes->group('', ['filter' => 'noauth'], function($routes) {
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::loginPost');
    $routes->get('/register', 'Auth::register');
    $routes->post('/register', 'Auth::registerPost'); 
});

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/keranjang', 'Keranjang::index');
    $routes->post('/keranjang/tambah', 'Keranjang::tambah');
    $routes->get('keranjang/hapus/(:num)', 'Keranjang::hapus/$1');

    $routes->get('/checkout', 'Checkout::index');
    $routes->post('/checkout/process', 'Checkout::process');

    $routes->get('/transaksi', 'Transaksi::index');
    $routes->get('/transaksi/confirm/(:num)', 'Transaksi::confirmPayment/$1');
    $routes->get('/logout', 'Auth::logout');
});
