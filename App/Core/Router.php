<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function register($route, $action) {
        $this->routes[$route] = $action;
    }

    public function resolve($requestUri) {
        $path = parse_url($requestUri, PHP_URL_PATH);
        $basePath = realpath(__DIR__ . '/../../'); 

        if (array_key_exists($path, $this->routes)) {
            [$class, $method] = explode('@', $this->routes[$path]);
            $controller = "App\\Controllers\\" . $class;
            $controller = new $controller();
            return $controller->$method();
        } else {
            header("HTTP/1.1 404 Not Found");
            include "{$basePath}/App/Views/404.phtml";
            exit;
        }
    }
}