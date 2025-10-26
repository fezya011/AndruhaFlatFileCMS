<?php

namespace App\Controllers;

use App\Core\Template;
use App\Core\Auth;
use App\Core\Security;
use App\Models\ContentManager;
use App\Services\FileUploader;

class AdminController
{
    private $template;
    private $contentManager;
    private $fileUploader;
    
    public function __construct()
    {
        $this->template = new Template();
        $this->contentManager = new ContentManager();
        $this->fileUploader = new FileUploader();
        
        if (!$this->isLoginPage() && !Auth::check()) {
            $this->redirect('/admin.php?action=login');
        }
    }
    
    public function dashboard()
    {
        $pages = $this->contentManager->getAllPages();
        $posts = $this->contentManager->getAllPosts();
        $mediaFiles = $this->contentManager->getMediaFiles();
        
        return $this->template->render('admin/dashboard', [
            'title' => 'Дашборд',
            'icon' => 'tachometer-alt',
            'pages' => $pages,
            'posts' => $posts,
            'mediaFiles' => $mediaFiles
        ]);
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (Auth::login($username, $password)) {
                $this->redirect('/admin.php');
            } else {
                $error = 'Неверные учетные данные';
            }
        }
        
        return $this->template->render('admin/login', [
            'title' => 'Вход в панель управления',
            'error' => $error ?? null
        ]);
    }
    
    public function logout()
    {
        Auth::logout();
        $this->redirect('/admin.php?action=login');
    }
    
    public function editPost()
{
    $postSlug = $_GET['post'] ?? '';
    $isNew = empty($postSlug);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = Security::sanitizeInput($_POST['title'] ?? '');
        $content = $_POST['content'] ?? '';
        $slug = Security::sanitizeInput($_POST['slug'] ?? '');
        
        if ($title && $content && $slug && Security::validateSlug($slug)) {
            $frontMatter = "---\ntitle: \"{$title}\"\ndate: \"" . date('Y-m-d') . "\"\n---\n\n";
            $fullContent = $frontMatter . $content;
            
            if ($this->contentManager->savePost($slug, $fullContent)) {
                $this->redirect('/admin.php?action=edit_post&post=' . $slug . '&saved=1');
            }
        }
    }
    
    // Загрузка данных для формы
    $postData = null;
    $content = '';
    
    if ($postSlug) {
        $postData = $this->contentManager->getPost($postSlug);
        $content = $postData['raw_content'] ?? '';
    } else {
        $content = "## Введение\n\nНачните писать вашу статью здесь...\n\n## Основная часть\n\n## Заключение";
        $postData = ['meta' => ['title' => '']];
    }
    
    $this->template->render('admin/edit_post', [
        'title' => $isNew ? 'Создать статью' : 'Редактирование статьи',
        'postSlug' => $postSlug,
        'content' => $content,
        'postData' => $postData,
        'isNew' => $isNew,
        'saved' => isset($_GET['saved'])
    ]);
}

public function editPage()
    {
        $pageName = $_GET['page'] ?? '';
        $isNew = empty($pageName);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageName = Security::sanitizeInput($_POST['page_name'] ?? '');
            $title = Security::sanitizeInput($_POST['title'] ?? '');
            $content = $_POST['content'] ?? '';
            
            if ($pageName && $title && $content) {
                $frontMatter = "---\ntitle: \"{$title}\"\ndate: \"" . date('Y-m-d') . "\"\n---\n\n";
                $fullContent = $frontMatter . $content;
                
                if ($this->contentManager->savePage($pageName, $fullContent)) {
                    $this->redirect('/admin.php?action=edit_page&page=' . $pageName . '&saved=1');
                }
            }
        }
        
        // Загрузка данных для формы
        $pageData = null;
        $content = '';
        
        if ($pageName) {
            $pageData = $this->contentManager->getPage($pageName);
            $content = $pageData['raw_content'] ?? '';
        } else {
            $content = "## Заголовок\n\nНачните писать содержимое страницы здесь...";
            $pageData = ['meta' => ['title' => '']];
        }
        
        $this->template->render('admin/edit_page', [
            'title' => $isNew ? 'Создать страницу' : 'Редактирование страницы',
            'pageName' => $pageName,
            'content' => $content,
            'pageData' => $pageData,
            'isNew' => $isNew,
            'saved' => isset($_GET['saved'])
        ]);
    }
        
    public function uploadMedia()
    {
        $message = null;
        $messageType = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $result = $this->fileUploader->handleUpload($_FILES['file']);
            
            if ($result['success']) {
                $message = 'Файл успешно загружен!';
                $messageType = 'success';
            } else {
                $message = $result['error'];
                $messageType = 'error';
            }
        }

        $mediaFiles = $this->contentManager->getMediaFiles();
        
        return $this->template->render('admin/upload_media', [
            'title' => 'Загрузка медиафайлов',
            'icon' => 'images',
            'mediaFiles' => $mediaFiles,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
    
    public function deletePost()
    {
        $postSlug = $_GET['post'] ?? '';
        
        if ($postSlug) {
            $this->contentManager->deletePost($postSlug);
            $this->redirect('/admin.php?action=manage_posts&deleted=1');
        }
        
        $this->redirect('/admin.php?action=manage_posts');
    }

    public function deletePage()
    {
        $pageName = $_GET['page'] ?? '';
        
        if ($pageName && !in_array($pageName, ['home', 'about', 'contact'])) {
            $this->contentManager->deletePage($pageName);
            $this->redirect('/admin.php?action=manage_pages&deleted=1');
        }
        
        $this->redirect('/admin.php?action=manage_pages');
    }

    public function managePosts()
    {
        $postsData = $this->contentManager->getAllPosts();
        
        $this->template->render('admin/manage_posts', [
            'title' => 'Управление статьями',
            'icon' => 'newspaper',
            'posts' => $postsData
        ]);
    }

    public function managePages()
    {
        $pagesData = $this->contentManager->getAllPages();
        
        // Преобразуем данные для отображения
        $pages = [];
        foreach ($pagesData as $pageData) {
            $pages[] = [
                'name' => $pageData['slug'], // имя файла
                'title' => $pageData['meta']['title'] ?? $pageData['slug'] // заголовок из front matter
            ];
        }
        
        $this->template->render('admin/manage_pages', [
            'title' => 'Управление страницами',
            'icon' => 'file',
            'pages' => $pages
        ]);
    }
    
    private function isLoginPage()
    {
        return ($_GET['action'] ?? '') === 'login';
    }
    
    private function redirect($url)
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo '<script>window.location.href="' . $url . '";</script>';
            exit;
        }
    }
}