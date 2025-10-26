<?php

namespace App\Core;

class Template
{
    public function render($view, $data = [])
    {
        extract($data);
        
        $view = ltrim($view, '/');
        
        $possiblePaths = [
            TEMPLATE_PATH . '/pages/' . $view . '.php',
            TEMPLATE_PATH . '/admin/' . $view . '.php',
            TEMPLATE_PATH . '/' . $view . '.php',
            str_replace('admin/admin/', 'admin/', TEMPLATE_PATH . '/' . $view . '.php')
        ];
        
        $possiblePaths = array_unique($possiblePaths);
        
        $viewPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $viewPath = $path;
                break;
            }
        }
        
        if (!$viewPath) {
            throw new \Exception("View '{$view}' not found");
        }
        
        // Буферизуем контент
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        
        // Определяем layout
        if (strpos($view, 'admin/') === 0) {
            $layoutPath = TEMPLATE_PATH . '/layouts/admin.php';
        } else {
            $layoutPath = TEMPLATE_PATH . '/layouts/main.php';
        }
        
        // Если layout существует, рендерим через него
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo $content;
        }
        
        return '';
    }
}