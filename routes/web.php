<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*EndPoints*/

$router->get("/api/cars", "CarsController@getAll");

$router->group(['prefix'=> "/api/car"], function() use ($router){
    $router->get("/{id}", "CarsController@get");
    $router->post("/", "CarsController@store");
    $router->put("/{id}", "CarsController@update");
    $router->delete("/{id}", "CarsController@destroy");
});


$router->get('/', function () use ($router) {
    return $router->app->version();
});
