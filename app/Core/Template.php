<?php

namespace App\Core;

class Template
{
    public function render($view, $data = [])
    {
        // Извлекаем переменные
        extract($data, EXTR_SKIP);

        $view = ltrim($view, '/');

        // Определяем путь к view файлу
        $viewPath = $this->findViewFile($view);

        if (!$viewPath) {
            throw new \Exception("View '{$view}' not found. Searched in: " . implode(', ', [
                    TEMPLATE_PATH . '/pages/' . $view . '.php',
                    TEMPLATE_PATH . '/admin/' . $view . '.php',
                    TEMPLATE_PATH . '/' . $view . '.php'
                ]));
        }

        // Буферизуем view
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        // Определяем layout
        $layoutPath = $this->getLayoutPath($view);

        // Если layout существует, рендерим через него
        if ($layoutPath && file_exists($layoutPath)) {
            ob_start();
            include $layoutPath;
            return ob_get_clean();
        }

        return $content;
    }

    private function findViewFile($view): ?string
    {
        $possiblePaths = [
            TEMPLATE_PATH . '/pages/' . $view . '.php',
            TEMPLATE_PATH . '/admin/' . $view . '.php',
            TEMPLATE_PATH . '/' . $view . '.php',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    private function getLayoutPath($view): string
    {
        if (strpos($view, 'admin/') === 0) {
            return TEMPLATE_PATH . '/layouts/admin.php';
        } else {
            return TEMPLATE_PATH . '/layouts/main.php';
        }
    }
}