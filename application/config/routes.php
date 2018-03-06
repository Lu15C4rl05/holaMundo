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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'rutas';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

//Routes para pasajeros del WSAppFlota
$route['pasajeros']['get'] = 'pasajeros';
$route['pasajeros/(:num)']['get'] = 'pasajeros/find/$1';
$route['pasajeros']['post'] = 'pasajeros/index';
$route['pasajeros/(:num)']['put'] = 'pasajeros/index/$1';
$route['pasajeros/(:num)']['delete'] = 'pasajeros/index/$1';

//Routes para clientes del WSAppFlota
$route['clientes']['get'] = 'clientes';
$route['clientes/(:num)']['get'] = 'clientes/find/$1';
$route['clientes']['post'] = 'clientes/index';
$route['clientes/(:num)']['put'] = 'clientes/index/$1';
$route['clientes/(:num)']['delete'] = 'clientes/index/$1';

//Routes para boletos del WSAppFlota
$route['boletos']['get'] = 'boletos';
$route['boletos/(:num)']['get'] = 'boletos/find/$1';
$route['boletos']['post'] = 'boletos/index';
$route['boletos']['post'] = 'boletos/index2';
//$route['boletos/(:num)']['put'] = 'boletos/index/$1';
$route['boletos/(:num)']['delete'] = 'boletos/index/$1';

//Routes para rutas del WSAppFlota
$route['rutas']['get'] = 'rutas';
$route['rutas/(:num)']['get'] = 'rutas/find/$1';
$route['rutas']['post'] = 'rutas/index';
$route['rutas/(:num)']['put'] = 'rutas/index/$1';
$route['rutas/(:num)']['delete'] = 'rutas/index/$1';

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
