<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->match(['get', 'post'], 'forgot-password', 'AuthController::forgotPassword');
$routes->get('reset-password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('reset-password/update', 'AuthController::attemptReset');

// RBAC Protected Routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    
    // Profile
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile', 'ProfileController::update');

    // Activity Logs
    $routes->get('logs', 'LogsController::index', ['filter' => 'rbac:logs.view']); // Assuming permission name 'logs.view' or general access

    // User Routes
    $routes->group('users', function($routes) {
        $routes->get('', 'UserController::index', ['filter' => 'rbac:users.view']);
        $routes->get('create', 'UserController::create', ['filter' => 'rbac:users.create']);
        $routes->post('store', 'UserController::store', ['filter' => 'rbac:users.create']);
        $routes->get('edit/(:num)', 'UserController::edit/$1', ['filter' => 'rbac:users.edit']);
        $routes->post('update/(:num)', 'UserController::update/$1', ['filter' => 'rbac:users.edit']);
        $routes->get('delete/(:num)', 'UserController::delete/$1', ['filter' => 'rbac:users.delete']);
        
        // Assign Roles
        $routes->get('roles/(:num)', 'UserController::roles/$1', ['filter' => 'rbac:users.edit']);
        $routes->post('roles/update/(:num)', 'UserController::updateRoles/$1', ['filter' => 'rbac:users.edit']);
    });
    
    // Role Routes
    $routes->group('roles', function($routes) {
        $routes->get('', 'RoleController::index', ['filter' => 'rbac:roles.view']);
        $routes->get('create', 'RoleController::create', ['filter' => 'rbac:roles.create']);
        $routes->post('store', 'RoleController::store', ['filter' => 'rbac:roles.create']);
        $routes->get('edit/(:num)', 'RoleController::edit/$1', ['filter' => 'rbac:roles.edit']);
        $routes->post('update/(:num)', 'RoleController::update/$1', ['filter' => 'rbac:roles.edit']);
        $routes->get('delete/(:num)', 'RoleController::delete/$1', ['filter' => 'rbac:roles.delete']);
        
        // Assign Permissions
        $routes->get('permissions/(:num)', 'RoleController::permissions/$1', ['filter' => 'rbac:roles.edit']);
        $routes->post('permissions/update/(:num)', 'RoleController::updatePermissions/$1', ['filter' => 'rbac:roles.edit']);
    });
    
    // Permission Routes
    $routes->group('permissions', function($routes) {
        $routes->get('', 'PermissionController::index', ['filter' => 'rbac:permissions.view']);
        $routes->get('create', 'PermissionController::create', ['filter' => 'rbac:permissions.create']);
        $routes->post('store', 'PermissionController::store', ['filter' => 'rbac:permissions.create']);
        $routes->get('edit/(:num)', 'PermissionController::edit/$1', ['filter' => 'rbac:permissions.edit']);
        $routes->post('update/(:num)', 'PermissionController::update/$1', ['filter' => 'rbac:permissions.edit']);
        $routes->get('delete/(:num)', 'PermissionController::delete/$1', ['filter' => 'rbac:permissions.delete']);
    });
});
