<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->add('/','Home::index', ['filter' => 'auth']);

// Employe/Company Routes with Auth Filters
$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('home', 'Home::index');
    $routes->get('contact-us', 'Home::contact_us');
    $routes->get('terms-service', 'Home::terms_of_service');
    $routes->get('privacy-policy', 'Home::privacy_policy');

    $routes->get('employee-center', 'EmployeeController::employee_center');
    $routes->get('Add-Employee', 'EmployeeController::employee_form');
    $routes->post('store_employee', 'EmployeeController::store');
    $routes->post('update_employee', 'EmployeeController::update');
    $routes->get('employee-show/(:num)', 'EmployeeController::show/$1');
    $routes->get('employee-edit/(:num)', 'EmployeeController::edit/$1');
    $routes->get('employee-delete/(:num)', 'EmployeeController::delete/$1');
    $routes->post('get_email', 'Home::get_email');
    
    $routes->get('docket-no', 'DocketController::index');
    $routes->get('dockets', 'DocketController::dockets');
    $routes->post('get_docket_no', 'DocketController::get_docket_no');
    $routes->post('store_docket', 'DocketController::store_docket');
    $routes->post('assign_docket', 'DocketController::assign_docket');
    $routes->get('docket-details/(:num)', 'DocketController::assign_details/$1');
    
    $routes->get('time-keeping', 'TimekeepingController::index');    
    $routes->post('get_docket_details_for_timekeeping', 'TimekeepingController::get_docket_details_for_timekeeping');    
});

//Super Admin Routes Without any filter
$routes->group('admin', function ($routes) {
$routes->get('login', 'AdminController::login', ['as' => 'admin/login']);
$routes->post('login', 'AdminController::attemptLogin');
$routes->get('logout', 'AuthController::adminLogout');
});


//Super Admin Routes with Auth Check Filters
$routes->group('admin', ['filter' => 'AuthAdminFilter'], function ($routes) {
    $routes->get('index', 'AdminController::index');
    $routes->get('index', 'AdminController::index');
    
});

$routes->get('company/store', 'Company::store');
$routes->get('employee-verify/(:any)', 'EmployeeController::employee_verify/$1');
$routes->post('set_password', 'EmployeeController::set_password');




//Myth/Auth Default routes
$routes->group('', function ($routes) {
    // Login/out
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');
    $routes->get('user/logout', 'AuthController::userLogout');

    // Registration
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');

    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
