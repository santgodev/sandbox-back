<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('auth/login', 'Sinapptic\AuthController::login');

// Group of routes for modules
$routes->group('modules', ['namespace' => 'App\Controllers\Sinapptic'], function($routes) {
    $routes->get('/', 'ModuleController::listModules');
    $routes->get('modules_components', 'ModuleController::listModules_Components');
    $routes->post('authorized', 'ModuleController::listAuthorizedModules');
});

// Group of routes for components
$routes->group('components', ['namespace' => 'App\Controllers\Sinapptic'], function($routes) {
    $routes->get('/', 'ComponentController::listComponents');
    $routes->post('authorized', 'ComponentController::listAuthorizedComponents');
});

// Group of routes for users
// $routes->group('users', ['namespace' => 'App\Controllers\Sinapptic'], function($routes) {
//     $routes->get('/', 'UserController::listUsers');
//     $routes->post('list', 'UserController::listUserById');
//     $routes->post('insert', 'UserController::insertUser');
//     $routes->put('update', 'UserController::updateUser');
//     $routes->post('delete', 'UserController::deleteUser');
// });

// Group of routes for roles
// $routes->group('roles', ['namespace' => 'App\Controllers\Sinapptic'], function($routes) {
//     $routes->get('/', 'RoleController::listRoles');
//     $routes->post('id', 'RoleController::listRoleById');
//     $routes->post('insert', 'RoleController::insertRole');
//     $routes->put('update', 'RoleController::updateRole');
//     $routes->post('delete', 'RoleController::deleteRole');
// });

$routes->group('clients', ['namespace' => 'App\Controllers\Clients'], function($routes) {
    $routes->get('/', 'ClientController::listClients');
    $routes->post('list', 'ClientController::listClientById');
    $routes->post('insert', 'ClientController::insertClient');
    $routes->post('update', 'ClientController::updateClient');
    $routes->post('delete', 'ClientController::deleteClient');
});

$routes->group('clients/users', ['namespace' => 'App\Controllers\Clients'], function($routes) {
    $routes->get('/', 'UserClientController::userClientList');
    $routes->post('list', 'UserClientController::userClientGetById');
    $routes->post('insert', 'UserClientController::userClientInsert');
    $routes->post('update', 'UserClientController::userClientUpdate');
    $routes->post('delete', 'UserClientController::userClientDelete');
});

$routes->group('clients/assets', ['namespace' => 'App\Controllers\Clients'], function($routes) {
    $routes->get('/', 'AssetController::listAssets');
    $routes->get('free', 'AssetController::listFreeAssets');
    $routes->post('listbyuserid', 'AssetController::getAssetsByUserClientId');
    $routes->post('insert', 'AssetController::insertAsset');
    $routes->put('update', 'AssetController::updateAsset');
    $routes->put('assinguser', 'AssetController::assingUser');
    $routes->put('undessinguser', 'AssetController::undessingUser');
    $routes->post('delete', 'AssetController::deleteAsset');
});



