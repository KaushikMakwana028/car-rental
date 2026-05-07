<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/login';
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/dashboard'] = 'admin/dashboard/index';
$route['admin/profile'] = 'admin/profile/index';
$route['admin/profile/update'] = 'admin/profile/update';
$route['admin/profile/password'] = 'admin/profile/password';
$route['admin/bookings'] = 'admin/booking/index';
$route['admin/bookings/create'] = 'admin/booking/create';
$route['admin/bookings/store'] = 'admin/booking/store';
$route['admin/customers'] = 'admin/customer/index';
$route['admin/documents'] = 'admin/document/index';
$route['admin/documents/review/(:num)'] = 'admin/document/review/$1';
$route['admin/documents/update-status'] = 'admin/document/update_status';
$route['admin/vehicles'] = 'admin/vehicle/index';
$route['admin/vehicles/create'] = 'admin/vehicle/create';
$route['admin/vehicles/store'] = 'admin/vehicle/store';
$route['admin/vehicles/update/(:num)'] = 'admin/vehicle/update/$1';
$route['admin/vehicles/delete/(:num)'] = 'admin/vehicle/delete/$1';
$route['admin/payments'] = 'admin/payment/index';
$route['admin/payments/requests'] = 'admin/payment/index';
$route['admin/payments/settings'] = 'admin/payment/settings';
$route['admin/payments/settings/save'] = 'admin/payment/save_settings';
$route['admin/payments/approve/(:num)'] = 'admin/payment/approve/$1';
$route['admin/payments/reject/(:num)'] = 'admin/payment/reject/$1';
$route['admin/payments/store'] = 'admin/payment/store';

$route['customer'] = 'dashboard';
$route['dashboard'] = 'dashboard/index';
$route['login'] = 'login';
$route['register'] = 'login/register';
$route['logout'] = 'login/logout';
$route['profile'] = 'profile/index';
$route['profile/update'] = 'profile/update';
$route['profile/password'] = 'profile/password';
$route['bookings'] = 'booking/index';
$route['bookings/create'] = 'booking/create';
$route['bookings/store'] = 'booking/store';
$route['bookings/cancel/(:num)'] = 'booking/cancel/$1';
$route['documents'] = 'document/index';
$route['documents/store'] = 'document/store';
$route['documents/delete/(:num)'] = 'document/delete/$1';
$route['payments'] = 'payment/index';
$route['payments/pay/(:num)'] = 'payment/pay/$1';
$route['payments/store'] = 'payment/store';
$route['vehicles'] = 'vehicle/index';
$route['vehicles/create'] = 'vehicle/create';
$route['customer/login'] = 'login';
$route['customer/logout'] = 'login/logout';
$route['customer/dashboard'] = 'dashboard/index';
$route['customer/profile'] = 'profile/index';
$route['customer/profile/update'] = 'profile/update';
$route['customer/profile/password'] = 'profile/password';
$route['customer/bookings'] = 'booking/index';
$route['customer/bookings/create'] = 'booking/create';
$route['customer/bookings/store'] = 'booking/store';
$route['customer/bookings/cancel/(:num)'] = 'booking/cancel/$1';
$route['customer/documents'] = 'document/index';
$route['customer/documents/store'] = 'document/store';
$route['customer/documents/delete/(:num)'] = 'document/delete/$1';
$route['customer/payments'] = 'payment/index';
$route['customer/payments/pay/(:num)'] = 'payment/pay/$1';
$route['customer/payments/store'] = 'payment/store';
$route['customer/vehicles'] = 'vehicle/index';
$route['customer/vehicles/create'] = 'vehicle/create';

$route['api/admin/login'] = 'api/admin_login';
$route['api/admin/register'] = 'api/admin_register';
$route['api/customer/login'] = 'api/customer_login';
$route['api/customer/register'] = 'api/customer_register';
$route['api/vehicles'] = 'api/vehicles';
$route['api/bookings/create'] = 'api/create_booking';
$route['api/dashboard'] = 'api/dashboard';
