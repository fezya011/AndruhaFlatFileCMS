<?php

namespace App\Controllers;

use App\Core\Template;
use App\Models\ContentManager;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\JsonResponse;

abstract class BaseController
{
    protected Template $template;
    protected ContentManager $contentManager;

    public function __construct(Template $template, ContentManager $contentManager)
    {
        $this->template = $template;
        $this->contentManager = $contentManager;
    }

    protected function render(string $view, array $data = []): ResponseInterface
    {
        try {
            // Добавляем отладочную информацию
            error_log("Rendering view: {$view}");
            error_log("Data: " . print_r($data, true));

            $content = $this->template->render($view, $data);

            $response = new Response();
            $response->getBody()->write($content);
            return $response;
        } catch (\Exception $e) {
            error_log("Template rendering error: " . $e->getMessage());

            // Фолбэк на случай ошибки рендеринга
            $response = new Response();
            $response->getBody()->write('
                <h1>Ошибка рендеринга</h1>
                <p>' . htmlspecialchars($e->getMessage()) . '</p>
                <p>View: ' . htmlspecialchars($view) . '</p>
            ');
            return $response->withStatus(500);
        }
    }

    protected function redirect(string $url): ResponseInterface
    {
        return new RedirectResponse($url);
    }

    protected function json(array $data): ResponseInterface
    {
        return new JsonResponse($data);
    }
}