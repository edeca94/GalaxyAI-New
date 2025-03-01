<?php

use App\Core\Router;

$directory = new RecursiveDirectoryIterator(__DIR__ . '/../config');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    require_once $file[0];
}

function _prettyNumber(int $number): string
{
    return number_format($number, 0, '', '.');
}


$router = new Router();

$router->register('/', 'HomeController@index');
$router->register('/login', 'HomeController@login');
$router->register('/register', 'HomeController@register');
$router->register('/logout', 'LogoutController@index');

//INGAME
$router->register('/overview', 'OverviewController@index');

$router->register('/buildings', 'BuildingsController@index');
/*$router->register('/buildings/startConstruction', 'BuildingsController@startConstruction');
$router->register('/buildings/removeFromQueue', 'BuildingsController@removeFromQueue');
$router->register('/buildings/handleQueue', 'BuildingsController@handleQueue');
$router->register('/buildings/getActiveBuildings', 'BuildingsController@getActiveBuildings');*/
$router->register('/buildings/addToQueue', 'BuildingsController@addToQueue');
$router->register('/buildings/removeFromQueue', 'BuildingsController@removeFromQueue');

$router->register('/facilities', 'FacilitiesController@index');
$router->register('/research', 'ResearchController@index');
$router->register('/shipyard', 'ShipyardController@index');
$router->register('/defense', 'DefenseController@index');
$router->register('/messages', 'MessageController@index');
$router->register('/alliance', 'AllianceController@index');

//ADMIN
$router->register('/dashboard', 'DashboardController@index');