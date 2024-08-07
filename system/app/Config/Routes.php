<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//WEB ROUTER ------------------------------------------------------
//------------------------------------------------------------------
$routes->get('/', 'Site::index');
$routes->get('lang/{locale}', 'Language::index');

//API ROUTER ------------------------------------------------------
//------------------------------------------------------------------
$routes->get('api/','Api::index');
$routes->get('api/status','Api::status');
$routes->post('api/signIn','Api::signIn');

//API ROUTER USER ------------------------------------------------------
//------------------------------------------------------------------
$routes->get('api/user/','Api::user/all');
$routes->get('api/user/(:segment)','Api::user/id/$1');
$routes->post('api/user/','Api::user/add');
$routes->put('api/user/(:segment)','Api::user/edit/$1');
$routes->delete('api/user/(:segment)','Api::user/delete/$1');

