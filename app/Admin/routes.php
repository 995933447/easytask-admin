<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('task-callback-srvs', TaskCallbackSrvController::class);
    $router->resource('task-callback-srv-routes', TaskCallbackSrvRouteController::class);
    $router->resource('tasks', TaskController::class);
    $router->resource('task-logs', TaskLogController::class);
    
});
