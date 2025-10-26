<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function addRoute($path, $handler)
    {
        $this->routes[$path] = $handler;
    }

    public function dispatch()
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = rtrim($path, '/') ?: '/';

        // Статические маршруты
        if (isset($this->routes[$path])) {
            return $this->executeHandler($this->routes[$path]);
        }

        // Динамические маршруты для статей
        if (preg_match('#^/post/([a-z0-9-]+)$#', $path, $matches)) {
            $controller = new \App\Controllers\PageController();
            return $controller->showPost($matches[1]);
        }

        // Динамические страницы
        if (preg_match('#^/([a-z0-9-]+)$#', $path, $matches) && $matches[1] !== 'admin') {
            $pageName = $matches[1];
            $controller = new \App\Controllers\PageController();
            
            $filePath = CONTENT_PATH . "/pages/{$pageName}.md";
            if (file_exists($filePath)) {
                return $controller->showPage($pageName);
            }
        }

        $this->show404();
    }

    private function executeHandler($handler)
    {
        if (is_callable($handler)) {
            return $handler();
        } elseif (is_string($handler) && strpos($handler, '@') !== false) {
            list($controller, $method) = explode('@', $handler);
            $controllerClass = "App\\Controllers\\{$controller}";
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $method)) {
                    return $controllerInstance->$method();
                }
            }
        }
        
        $this->show404();
    }

    private function show404()
    {
        http_response_code(404);
        $template = new Template();
        echo $template->render('404', [
            'title' => '404 - Страница не найдена'
        ]);
        exit;
    }
}