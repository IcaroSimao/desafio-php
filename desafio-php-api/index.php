<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

date_default_timezone_set("America/Sao_Paulo");

include_once "src/autoload.php";
new Autoload();

$routes = new Routes();

// Product
$routes->add('GET', '/product', 'Product::getAll');
$routes->add('GET', '/product/?', 'Product::getById');
$routes->add('POST', '/product', 'Product::save');
$routes->add('POST', '/product/delete/?', 'Product::delete');

// ProductType
$routes->add('GET', '/productType', 'ProductType::getAll');
$routes->add('GET', '/productType/?', 'ProductType::getById');
$routes->add('POST', '/productType', 'ProductType::save');
$routes->add('POST', '/productType/delete/?', 'ProductType::delete');

// Sale
$routes->add('GET', '/sale', 'Sale::getAll');
$routes->add('GET', '/sale/?', 'Sale::getById');
$routes->add('POST', '/sale', 'Sale::save');
$routes->add('POST', '/sale/delete/?', 'Sale::delete');

// Initialize
$routes->go($_SERVER['REQUEST_URI']);
