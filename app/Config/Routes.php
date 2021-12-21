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
$routes->setTranslateURIDashes(true);
$routes->set404Override(function () {
    echo view('404page');
});
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->add('/','Home::index', ['filter' => 'auth']);


$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('/',                       'Home::index');
    $routes->get('home',                    'Home::index');
    $routes->post('get_email',              'Home::getEmail');
    $routes->get('contact-us',              'Home::contact_us');
    $routes->get('terms-service',           'Home::terms_of_service');
    $routes->get('privacy-policy',          'Home::privacy_policy');

    $routes->get('add-employee',            'EmployeeController::employeeForm');
    $routes->post('store_employee',         'EmployeeController::store');
    $routes->get('employee-center',         'EmployeeController::employeeCenter');
    $routes->post('update_employee',        'EmployeeController::update');
    $routes->get('employee-show/(:num)',    'EmployeeController::show/$1');
    $routes->get('employee-edit/(:num)',    'EmployeeController::edit/$1');
    $routes->get('employee-delete/(:num)',  'EmployeeController::delete/$1');
    
    $routes->get('dockets',                 'DocketController::dockets');
    $routes->get('docket-no',               'DocketController::index');
    $routes->post('store_docket',           'DocketController::storeDocket');
    $routes->post('get_docket_no',          'DocketController::getDocketNo');
    $routes->post('assign_docket',          'DocketController::assignDocket');
    $routes->post('get-docket-assignee',    'DocketController::getdocketDetailByid');
    $routes->get('docket-details/(:num)',   'DocketController::assignDetails/$1');    

    $routes->get('activity',                'ActivityController::index');
    $routes->post('activity',               'ActivityController::index');

    $routes->get('company',                 'CompanyController::show');
    $routes->get('company-edit',            'CompanyController::edit');
    $routes->post('update-company',         'CompanyController::update');
    $routes->get('suspend-company',         'CompanyController::suspendCompany');

    $routes->post('time_in',                'TimekeepingController::timeIn');
    $routes->get('time-keeping',            'TimekeepingController::index');
    $routes->post('manual_time_in',         'TimekeepingController::manualTimeIn');
    $routes->post('get_docket_details',     'TimekeepingController::getDocketDetails');  
    $routes->post('get_time_keeping_data',  'TimekeepingController::getTimeKeepingData');
    
    $routes->get('settings',                'SettingsController::index');
    $routes->get('signature',               'SettingsController::signature');
    $routes->post('save_signature',         'SettingsController::saveSignature');
    $routes->get('mail-signature',          'SettingsController::mailSignature');
    $routes->post('update_signature',       'SettingsController::updateSignature');

    $routes->get('access-control',          'AccessControllController::index');
    $routes->get('add-permissions',         'AccessControllController::addPermissions');
    $routes->post('save-permission',        'AccessControllController::savePermission');
    $routes->get('delete-permission/(:num)','AccessControllController::deletePermission/$1');
    $routes->post('get_user_permissions',   'AccessControllController::getUserPermissions');
    $routes->post('assign_permissions',     'AccessControllController::assignPermissions');

    $routes->get('employee-attendance',     'AttendanceController::index');
    $routes->get('checkin',                 'AttendanceController::checkin');
    $routes->post('checkout',               'AttendanceController::checkout');
    $routes->post('break',                  'AttendanceController::break');
    $routes->post('resume',                 'AttendanceController::resume');

    $routes->get('reports',                 'ReportsController::index');
    $routes->get('timekeeping-report',      'ReportsController::timekeeping_report');
    $routes->post('timekeeping-report',     'ReportsController::timekeeping_report');

});
//Super Admin Routes Without any filter
$routes->group('admin', function ($routes) {
    $routes->get('/',                       'AdminController::login');
    $routes->get('login',                   'AdminController::login', ['as' => 'admin/login']);
    $routes->post('login',                  'AdminController::attemptLogin');
    $routes->get('logout',                  'AuthController::adminLogout');
    $routes->get('admin_logout',            'AuthController::admin_logout');
});


//Super Admin Routes with Auth Check Filters
$routes->group('admin', ['filter' => 'AuthAdminFilter'], function ($routes) {
    $routes->get('index',                       'AdminController::index');
    $routes->get('companies',                   'AdminController::companies');
    $routes->get('company-details/(:num)',      'AdminController::companyDetails/$1');
    $routes->get('disable_company/(:num)',      'AdminController::disableCompany/$1');
    $routes->get('enable_company/(:num)',       'AdminController::enableCompany/$1');
    $routes->get('mail-signature',              'AdminController::signature');
    $routes->post('update_signature',           'AdminController::updateSignature');
    $routes->get('subscription-plans',          'AdminController::subscriptionPlans');
    $routes->get('create-plans',                'AdminController::createPlan');
    $routes->post('save_plan',                  'AdminController::savePlan');
    $routes->get('subscription-delete/(:num)',  'AdminController::deletePlan/$1');
    $routes->get('subscription-edit/(:num)',    'AdminController::editPlan/$1');
    $routes->get('mailbox',                     'AdminController::mailBox');
    $routes->post('send_an_email',              'AdminController::sendEmail');
    
});

$routes->post('company/store',              'CompanyController::store');
$routes->get('employee-verify/(:any)',      'EmployeeController::employeeVerify/$1');
$routes->post('set_password',               'EmployeeController::setPassword');




//Myth/Auth Default routes
$routes->group('', function ($routes) {
    // Login/out
    $routes->get('login',                   'AuthController::login', ['as' => 'login']);
    $routes->post('login',                  'AuthController::attemptLogin');
    $routes->get('logout',                  'AuthController::logout');
    $routes->get('user/logout',             'AuthController::userLogout');
    // Registration
    $routes->get('register',                'AuthController::register', ['as' => 'register']);
    $routes->post('register',               'AuthController::attemptRegister');
    // Activation
    $routes->get('activate-account',        'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);
    // Forgot/Resets
    $routes->get('forgot',                  'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot',                 'AuthController::attemptForgot');
    $routes->get('reset-password',          'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password',         'AuthController::attemptReset');
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
