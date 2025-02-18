<?php

namespace App\Core;

abstract class Controller {
    protected $viewBag = [];

    protected function view($data = []) {
        $reflection = new \ReflectionClass($this);
        $controllerName = $reflection->getShortName();
        $controllerName = str_replace(ucfirst(KWRD_CONTROLLER), '', $controllerName);
        $backtrace = debug_backtrace();
        $methodName = $backtrace[1]['function'];
        $basePath = realpath(__DIR__ . '/../../'); 
        $viewPath = "{$basePath}/Views/{$controllerName}/{$methodName}" . EXT_PHTML;

        if (file_exists($viewPath)) {
            extract($data);
            ob_start();
            include $viewPath;
            $content = ob_get_clean();

            $title = $this->get('title') ?? SITE_NAME;

            include "{$basePath}/Views/layout/master" . EXT_PHTML;
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "View not found: {$viewPath}";
            exit;
        }
    }

    protected function ensureAuthenticated() {
        if (!isset($_SESSION[KWRD_USERID])) {
            header("Location: /login");
            exit;
        }
    }

    protected function set($key, $value) {
        $this->viewBag[$key] = $value;
    }

    protected function get($key) {
        return isset($this->viewBag[$key]) ? $this->viewBag[$key] : null;
    }
}