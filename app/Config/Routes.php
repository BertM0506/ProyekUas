<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home'); // Homepage default ke Home
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->get('/', 'Home::index');

// Route Publik untuk melihat SEMUA produk
$routes->get('/produk', 'Produk::index');
// Route untuk detail produk
$routes->get('/produk/detail/(:num)', 'Produk::detail/$1');

// Group route yang hanya bisa diakses jika BELUM login (misal: halaman login, register)
$routes->group('', ['filter' => 'noauth'], function($routes) {
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::loginPost');
});

// Group route yang hanya bisa diakses jika SUDAH login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index'); // Jika tetap ada dashboard
    $routes->get('/keranjang', 'Keranjang::index');
    $routes->post('/keranjang/tambah', 'Keranjang::tambah');
    $routes->get('keranjang/hapus/(:num)', 'Keranjang::hapus/$1'); // Jika ada fitur hapus

    $routes->get('/checkout', 'Checkout::index');
    $routes->post('/checkout/process', 'Checkout::process');

    $routes->get('/transaksi', 'Transaksi::index'); // Riwayat transaksi
    // ROUTE BARU UNTUK KONFIRMASI PEMBAYARAN
    $routes->get('/transaksi/confirm/(:num)', 'Transaksi::confirmPayment/$1');
    $routes->get('/logout', 'Auth::logout');


});

