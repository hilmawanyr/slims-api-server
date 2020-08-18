<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/articles[/?rows={limit}[&page={page}]]', [
	'middleware' => ['rowspage','authorization'], 
	'uses' => 'ArticleController@index'
]);

$router->get('/members[/?rows={limit}[&page={page}]]', [
	'middleware' => ['rowspage','authorization'],
	'uses' => 'MemberController@index'
]);

$router->get('/{id}/members', [
	'middleware' => 'authorization',
	'uses' => 'MemberController@getSpesificMember'
]);

$router->get('/members/{typeID}/type[/?rows={limit}[&page={page}]]', [
	'middleware' => ['rowspage','authorization'],
	'uses' => 'MemberController@getMemberByType'
]);