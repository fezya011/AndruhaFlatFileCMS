<?php
// Начинаем буферизацию
ob_start();

require_once '../vendor/autoload.php';
require_once '../config/settings.php';

use App\Core\Router;
use App\Controllers\PageController;

$router = new Router();

// Регистрируем маршруты
$router->addRoute('/', function() {
    $controller = new PageController();
    $controller->home();
});

$router->addRoute('/about', function() {
    $controller = new PageController();
    $controller->showPage('about');
});

$router->addRoute('/articles', function() {
    $controller = new PageController();
    $controller->showArticles();
});

$router->addRoute('/contact', function() {
    $controller = new PageController();
    $controller->showPage('contact');
});

// Запускаем роутер
$router->dispatch();

// Очищаем буфер
if (ob_get_level() > 0) {
    ob_end_flush();
}