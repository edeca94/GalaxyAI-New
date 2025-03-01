<?php

namespace App\Core;

use App\Services\EventService;
use App\Services\LoaderService;

abstract class Controller extends Core
{
    use Authenticator;

    protected $viewBag = [];
    protected $loaderService;
    protected $eventService;
    protected $currentController;

    public $baseData = [];

    public function __construct()
    {
        Core::__construct();
        $this->loaderService = new LoaderService();
        $this->baseData = [];
        $this->baseData = $this->loaderService->loadBaseData();
        $data['translator'] = $this->translator;
        $this->eventService = new EventService();
    }

    protected function view($data = [], $standAlone = false) 
    {
        $reflection = new \ReflectionClass($this);
        $controllerName = $reflection->getShortName();
        $controllerName = str_replace(ucfirst(KWRD_CONTROLLER), '', $controllerName);
        $this->currentController = $controllerName;
        $backtrace = debug_backtrace();
        $methodName = $backtrace[1]['function'];
        $basePath = realpath(__DIR__ . '/../../'); 
        $viewPath = "{$basePath}/Views/{$controllerName}/{$methodName}" . EXT_PHTML;

        if ($this->authenticate())
        {
            $this->eventService->evaluateQueue();
            $data = array_merge($data, $this->baseData);
        }
        
        if (file_exists($viewPath)) 
        {
            extract($data);
            ob_start();
            include $viewPath;
            $content = ob_get_clean();

            $title = $this->get('title') ?? SITE_NAME;

            if (!$standAlone)
            {
                include "{$basePath}/Views/layout/master" . EXT_PHTML;
            }
            else
            {
                echo $content;
            }
        } 
        else 
        {
            header("HTTP/1.1 404 Not Found");
            echo "View not found: {$viewPath}"; 
            exit;
        }
    }

    protected function ensureAuthenticated() 
    {
        if (!isset($_SESSION[KWRD_USERID])) 
        {
            header("Location: /");
            exit;
        }
    }

    protected function set($key, $value) 
    {
        $this->viewBag[$key] = $value;
    }

    protected function get($key) 
    {
        return isset($this->viewBag[$key]) ? $this->viewBag[$key] : null;
    }

    protected function jsonResponse($response)
    {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function handleQueue()
    {
        if (!empty($this->eventService->evaluateQueue()))
        {
            $this->jsonResponse(['success' => true]);
        }
        else
        {
            $this->jsonResponse(['success' => false]);
        }
    }
}