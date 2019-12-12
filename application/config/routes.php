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

//Routes para usuarios del WSAppFlota
$route['usuarios']['get'] = 'usuarios';//Lista todos los usuarios de la tabla
$route['usuarios/(:num)']['get'] = 'usuarios/find/$1';//Lista un usuario pasando su ID
$route['usuarios']['post'] = 'usuarios';//Inserta un usuario
$route['usuarios/update']['post'] = 'usuarios/update';//Actualiza al usuario
$route['usuarios/auth']['post'] = 'usuarios/existe';//Devuelve si un correo ya ha sido registrado o si los datos de un usuario y contraseña son correctos. Además genera un código de verificación de 4 dígitos.

//Routes para conductores del WSAppFlota
$route['conductores']['get'] = 'conductores';//Lista todos los conductores de la tabla
$route['conductores/(:num)']['get'] = 'conductores/find/$1';//Lista un conductor pasando su ID
$route['conductores']['post'] = 'conductores';//Inserta un conductor
$route['conductores/update']['post'] = 'conductores/update';//Actualiza al conductor

//Routes para ciudades del WSAppFlota
$route['ciudades']['get'] = 'ciudades';//Lista todas las ciudades de la tabla
$route['ciudades/(:num)']['get'] = 'ciudades/find/$1';//Lista una ciudad pasando su ID
$route['ciudades']['post'] = 'ciudades';//Inserta una ciudad
$route['ciudades/update']['post'] = 'ciudades/update';//Actualiza la ciudad

//Routes para roles de usuario del WSAppFlota
$route['rolesusuario/(:num)']['get'] = 'rolesusuario/find/$1';//Lista el(los) roles de un usuario pasando su ID
$route['rolesusuario']['post'] = 'rolesusuario';//Agrega un rol a un usuario.
$route['rolesusuario/update']['post'] = 'rolesusuario/update';//Actualiza el rol de un usuario.
$route['rolesusuario/delete']['post'] = 'rolesusuario/delete';//Elimina el rol de un usuario.

//Routes para empresas del WSAppFlota
$route['empresas']['get'] = 'empresas';//Lista todas las empresas de la tabla
$route['empresas/(:num)']['get'] = 'empresas/find/$1';//Lista una empresa pasando su ID
$route['empresas']['post'] = 'empresas';//Inserta una empresa
$route['empresas/update']['post'] = 'empresas/update';//Actualiza la empresa

//Routes para buses del WSAppFlota
$route['buses']['get'] = 'buses';//Lista los buses de la tabla que estan activos
$route['buses/inactivos']['get'] = 'buses/inactivos';//Lista los buses de la tabla que están inactivos
$route['buses/(:num)']['get'] = 'buses/find/$1';//Lista un bus pasando su ID
$route['buses']['post'] = 'buses';//Inserta un bus
$route['buses/update']['post'] = 'buses/update';//Actualiza los datos de un bus
$route['buses/setEstado']['post'] = 'buses/setEstado';//Itera el estado del bus entre activo e inactivo

//Routes para rutas del WSAppFlota
$route['rutas']['get'] = 'rutas';//Lista todas las rutas de la tabla.
$route['rutasDestino']['post'] = 'rutas/findD';//Muestra las ciudades destino que tiene la ciudad origen.
$route['rutasInfo']['post'] = 'rutas/find';//Muestra las horas de salida de la ruta entre las dos ciudades.
$route['rutas/(:any)/(:any)/(:any)']['get'] = 'rutas/findh/$1/$2/$3';//Muestra las horas de salida de la ruta entre las dos ciudades y en la fecha especificada.
$route['rutasimg']['get'] = 'rutas/findimg';//Obtiene la ruta "ORIGEN - DESTINO", la imagen de la ciudad destino y el número de boletos vendido de cada ruta. Esta función se utiliza para el apartado de "RUTAS MÁS VENDIDAS" en la app.
$route['rutas']['post'] = 'rutas';//Inserta una ruta
$route['rutas/update']['post'] = 'rutas/update';//Actualiza los datos de una ruta
$route['rutasOrigen']['get'] = 'rutas/ciudadesOrigen';//Lista la(s) ciudades origen de las rutas activas

//Routes para boletos del WSAppFlota
$route['boletos']['get'] = 'boletos';
$route['boletos/(:num)']['get'] = 'boletos/porIdBoleto/$1';
$route['boletos/empresa/(:num)']['get'] = 'boletos/porIdEmpresa/$1';
$route['boletos/ocupados']['post'] = 'boletos/asientosOcupados';
$route['boletos']['post'] = 'boletos';
$route['boletosRuta']['post'] = 'boletos/ruta';
$route['boletosCompras']['post'] = 'boletos/compras';
//$route['boletos/(:num)']['put'] = 'boletos/index/$1';

//--------------------------------------------------------------------------------------------------------

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
