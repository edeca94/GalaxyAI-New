<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/app.php';

$router->resolve($_SERVER['REQUEST_URI']);