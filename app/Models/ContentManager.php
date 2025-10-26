<?php

namespace App\Models;

use App\Core\ContentParser;

class ContentManager
{
    private $contentParser;
    
    public function __construct()
    {
        $this->contentParser = new ContentParser();
    }
    
    // Страницы
    public function getPage($pageName)
    {
        $filePath = CONTENT_PATH . "/pages/{$pageName}.md";
        return $this->loadContent($filePath);
    }
    
    public function getAllPages()
    {
        return $this->loadAllContent(CONTENT_PATH . '/pages/*.md');
    }
    
    public function savePage($pageName, $content)
    {
        return $this->saveContent(CONTENT_PATH . "/pages/{$pageName}.md", $content);
    }
    
    public function deletePage($pageName)
    {
        return $this->deleteContent(CONTENT_PATH . "/pages/{$pageName}.md");
    }
    
    public function pageExists($pageName)
    {
        return file_exists(CONTENT_PATH . "/pages/{$pageName}.md");
    }
    
    // Статьи
    public function getPost($postSlug)
    {
        $filePath = CONTENT_PATH . "/posts/{$postSlug}.md";
        return $this->loadContent($filePath);
    }
    
    public function getAllPosts($limit = null)
    {
        $posts = $this->loadAllContent(CONTENT_PATH . '/posts/*.md', true);
        
        if ($limit) {
            $posts = array_slice($posts, 0, $limit);
        }
        
        return $posts;
    }
    
    public function savePost($postSlug, $content)
    {
        return $this->saveContent(CONTENT_PATH . "/posts/{$postSlug}.md", $content);
    }
    
    public function deletePost($postSlug)
    {
        return $this->deleteContent(CONTENT_PATH . "/posts/{$postSlug}.md");
    }
    
    public function postExists($postSlug)
    {
        return file_exists(CONTENT_PATH . "/posts/{$postSlug}.md");
    }
    
    // Медиафайлы
    public function getMediaFiles()
    {
        $files = [];
        $mediaPath = UPLOAD_PATH;
        
        if (is_dir($mediaPath)) {
            $fileList = glob($mediaPath . '/*');
            foreach ($fileList as $file) {
                if (is_file($file)) {
                    $files[] = [
                        'name' => basename($file),
                        'size' => filesize($file),
                        'url' => '/media/uploads/' . basename($file)
                    ];
                }
            }
        }
        
        return $files;
    }
    
    // Приватные методы
    private function loadContent($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }
        
        $content = file_get_contents($filePath);
        $parsed = $this->contentParser->parseMarkdownWithFrontMatter($content);
        
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        $parsed['slug'] = $filename;
        
        return $parsed;
    }
    
    private function loadAllContent($pattern, $sortByDate = false)
    {
        $items = [];
        $files = glob($pattern);
        
        foreach ($files as $file) {
            $content = $this->loadContent($file);
            if ($content) {
                $items[] = $content;
            }
        }
        
        if ($sortByDate) {
            usort($items, function($a, $b) {
                $dateA = strtotime($a['meta']['date'] ?? '2000-01-01');
                $dateB = strtotime($b['meta']['date'] ?? '2000-01-01');
                return $dateB - $dateA;
            });
        }
        
        return $items;
    }
    
    private function saveContent($filePath, $content)
    {
        $dir = dirname($filePath);
        
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        return file_put_contents($filePath, $content) !== false;
    }
    
    private function deleteContent($filePath)
    {
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}