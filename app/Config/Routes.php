<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// LOGIN
$routes->get('/login', 'Auth::index');
$routes->post('/login/submit', 'Auth::submit');
$routes->get('/logout', 'Auth::logout');

// BARANG
$routes->get('/barang', 'Barang::index');
$routes->post('/barang-tambah', 'Barang::tambah');
$routes->add('/barang-ubah/(:segment)', 'Barang::ubah/$1');
$routes->get('/barang-hapus/(:segment)', 'Barang::hapus/$1');

// KATEGORI
$routes->get('/kategori', 'Kategori::index');
$routes->post('/kategori-tambah', 'Kategori::tambah');
$routes->add('/kategori-ubah/(:segment)', 'Kategori::ubah/$1');
$routes->get('/kategori-hapus/(:segment)', 'Kategori::hapus/$1');

// KARYAWAN
$routes->get('/karyawan', 'Karyawan::index');
$routes->post('/karyawan-tambah', 'Karyawan::tambah');
$routes->add('/karyawan-ubah/(:segment)', 'Karyawan::ubah/$1');
$routes->get('/karyawan-hapus/(:segment)', 'Karyawan::hapus/$1');

// ACTIVITY
$routes->get('/activity-single', 'Activity::single');
$routes->get('/activity-all', 'Activity::all');

// PERMINTAAN
$routes->get('/permintaan', 'Permintaan::index');
$routes->post('/permintaan-tambah', 'Permintaan::tambah');
$routes->post('/permintaan-by-id', 'Permintaan::tambah_by_id');
$routes->add('/permintaan-kelola/(:segment)', 'Permintaan::kelola/$1');
$routes->add('/permintaan-ulang/(:segment)', 'Permintaan::ulang/$1');
$routes->add('/permintaan-batal/(:segment)', 'Permintaan::batal/$1');
$routes->get('/permintaan-hapus/(:segment)', 'Permintaan::hapus/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
