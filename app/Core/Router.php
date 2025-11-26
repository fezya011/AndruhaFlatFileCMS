<?php

namespace App\Core;

use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;

class Router
{
    private $router;
    private $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->router = new LeagueRouter();

        $strategy = new ApplicationStrategy();
        $strategy->setContainer($this->container->getContainer());
        $this->router->setStrategy($strategy);

        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        // 0. РЕДИРЕКТ для старого пути admin.php
        $this->router->map('GET', '/admin.php', function (ServerRequestInterface $request): ResponseInterface {
            return new \Laminas\Diactoros\Response\RedirectResponse('/admin');
        });

        // 1. Статические маршруты
        $this->router->map('GET', '/', [\App\Controllers\PageController::class, 'home']);
        $this->router->map('GET', '/about', [\App\Controllers\PageController::class, 'showAbout']);
        $this->router->map('GET', '/articles', [\App\Controllers\PageController::class, 'showArticles']);
        $this->router->map('GET', '/contact', [\App\Controllers\PageController::class, 'showContact']);

        // 2. Статьи
        $this->router->map('GET', '/post/{slug}', [\App\Controllers\PageController::class, 'showPost']);
        $this->router->map('GET', '/posts/{slug}', [\App\Controllers\PageController::class, 'showPost']);

        // 3. Админские маршруты
        $this->router->map('GET', '/admin', [\App\Controllers\AdminController::class, 'dashboard']);
        $this->router->map('GET', '/admin/dashboard', [\App\Controllers\AdminController::class, 'dashboard']);
        $this->router->map('GET', '/admin/login', [\App\Controllers\AdminController::class, 'login']);
        $this->router->map('POST', '/admin/login', [\App\Controllers\AdminController::class, 'login']);
        $this->router->map('GET', '/admin/logout', [\App\Controllers\AdminController::class, 'logout']);
        $this->router->map('GET', '/admin/edit_page', [\App\Controllers\AdminController::class, 'editPage']);
        $this->router->map('POST', '/admin/edit_page', [\App\Controllers\AdminController::class, 'editPage']);
        $this->router->map('GET', '/admin/edit_post', [\App\Controllers\AdminController::class, 'editPost']);
        $this->router->map('POST', '/admin/edit_post', [\App\Controllers\AdminController::class, 'editPost']);
        $this->router->map('GET', '/admin/upload_media', [\App\Controllers\AdminController::class, 'uploadMedia']);
        $this->router->map('POST', '/admin/upload_media', [\App\Controllers\AdminController::class, 'uploadMedia']);
        $this->router->map('GET', '/admin/delete_post', [\App\Controllers\AdminController::class, 'deletePost']);
        $this->router->map('GET', '/admin/delete_page', [\App\Controllers\AdminController::class, 'deletePage']);
        $this->router->map('GET', '/admin/manage_posts', [\App\Controllers\AdminController::class, 'managePosts']);
        $this->router->map('GET', '/admin/manage_pages', [\App\Controllers\AdminController::class, 'managePages']);

        // 4. Отладочный маршрут
        $this->router->map('GET', '/debug/post/{slug}', function (ServerRequestInterface $request, array $args): ResponseInterface {
            $slug = $args['slug'];
            $contentManager = $this->container->get(\App\Models\ContentManager::class);
            $post = $contentManager->getPost($slug);

            $filePath = CONTENT_PATH . "/posts/{$slug}.md";
            $fileExists = file_exists($filePath);

            $response = "=== DEBUG POST ===\n";
            $response .= "Slug: {$slug}\n";
            $response .= "File exists: " . ($fileExists ? 'YES' : 'NO') . "\n";
            $response .= "File path: {$filePath}\n";

            if ($post) {
                $response .= "Post found: YES\n";
                $response .= "Title: " . ($post['meta']['title'] ?? 'NO TITLE') . "\n";
                $response .= "Has content: " . (!empty($post['content']) ? 'YES' : 'NO') . "\n";
            } else {
                $response .= "Post found: NO\n";
            }

            return new \Laminas\Diactoros\Response\TextResponse($response);
        });

        // 5. Динамические страницы - САМЫЙ ПОСЛЕДНИЙ маршрут
        $this->router->map('GET', '/{page}', [\App\Controllers\PageController::class, 'showPage']);
    }

    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        try {
            // Добавим отладочную информацию
            $path = $request->getUri()->getPath();
            error_log("=== ROUTER DISPATCH ===");
            error_log("Request path: " . $path);
            error_log("Request method: " . $request->getMethod());

            $response = $this->router->dispatch($request);

            error_log("Response status: " . $response->getStatusCode());
            error_log("=== ROUTER DISPATCH END ===");
            return $response;

        } catch (\League\Route\Http\Exception\NotFoundException $e) {
            error_log("404 Not Found for path: " . $request->getUri()->getPath());
            error_log("404 Exception: " . $e->getMessage());
            return $this->show404();
        } catch (\Exception $e) {
            error_log("Router error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return $this->showError($e->getMessage());
        }
    }

    private function show404(): ResponseInterface
    {
        $template = $this->container->get(Template::class);
        $content = $template->render('404', ['title' => '404 - Страница не найдена']);

        $response = new Response();
        $response->getBody()->write($content);
        return $response->withStatus(404);
    }

    private function showError(string $message): ResponseInterface
    {
        $template = $this->container->get(Template::class);
        $content = $template->render('error', [
            'title' => 'Ошибка',
            'message' => $message
        ]);

        $response = new Response();
        $response->getBody()->write($content);
        return $response->withStatus(500);
    }
}