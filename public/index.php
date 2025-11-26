<?php
// Включаем буферизацию В САМОМ НАЧАЛЕ
while (ob_get_level() > 0) {
    ob_end_clean();
}
ob_start();

require_once '../vendor/autoload.php';
require_once '../config/settings.php';

use App\Core\Router;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Diactoros\Response\RedirectResponse;

// Создаем запрос
$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

// РЕДИРЕКТ с /admin.php на /admin
$path = $request->getUri()->getPath();
if ($path === '/admin.php') {
    $response = new RedirectResponse('/admin');
    (new SapiEmitter())->emit($response);
    exit;
}

// Создаем и запускаем роутер
$router = new Router();

try {
    $response = $router->dispatch($request);
    (new SapiEmitter())->emit($response);
} catch (Exception $e) {
    // Фолбэк на случай критической ошибки
    http_response_code(500);
    echo '<h1>Ошибка приложения</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    exit;
}