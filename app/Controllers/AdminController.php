<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Security;
use App\Services\FileUploader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends BaseController
{
    private FileUploader $fileUploader;

    public function __construct(
        \App\Core\Template $template,
        \App\Models\ContentManager $contentManager,
        FileUploader $fileUploader
    ) {
        parent::__construct($template, $contentManager);
        $this->fileUploader = $fileUploader;
    }

    public function dashboard(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $pages = $this->contentManager->getAllPages();
        $posts = $this->contentManager->getAllPosts();
        $mediaFiles = $this->contentManager->getMediaFiles();

        return $this->render('admin/dashboard', [
            'title' => 'Дашборд',
            'icon' => 'tachometer-alt',
            'pages' => $pages,
            'posts' => $posts,
            'mediaFiles' => $mediaFiles
        ]);
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        // Если уже авторизован - редирект в админку
        if (Auth::check()) {
            return $this->redirect('/admin');
        }

        $error = null;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            if (Auth::login($username, $password)) {
                return $this->redirect('/admin');
            } else {
                $error = 'Неверные учетные данные';
            }
        }

        return $this->render('admin/login', [
            'title' => 'Вход в панель управления',
            'error' => $error
        ]);
    }

    public function logout(ServerRequestInterface $request): ResponseInterface
    {
        Auth::logout();
        return $this->redirect('/admin/login');
    }

    public function editPost(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        // Получаем параметры из query string
        $queryParams = $request->getQueryParams();
        $postSlug = $queryParams['post'] ?? '';
        $isNew = empty($postSlug);

        // Инициализируем переменные
        $postData = null;
        $content = '';
        $saved = false;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $title = Security::sanitizeInput($data['title'] ?? '');
            $content = $data['content'] ?? '';
            $slug = Security::sanitizeInput($data['slug'] ?? '');

            if ($title && $content && $slug && Security::validateSlug($slug)) {
                $frontMatter = "---\ntitle: \"{$title}\"\ndate: \"" . date('Y-m-d') . "\"\n---\n\n";
                $fullContent = $frontMatter . $content;

                if ($this->contentManager->savePost($slug, $fullContent)) {
                    $saved = true;
                    return $this->redirect('/admin/edit_post?post=' . $slug . '&saved=1');
                }
            }
        } else {
            // Для GET запроса проверяем параметр saved
            $saved = isset($queryParams['saved']);
        }

        // Загрузка данных для формы
        if ($postSlug) {
            $postData = $this->contentManager->getPost($postSlug);
            $content = $postData['raw_content'] ?? '';
        } else {
            $content = "## Введение\n\nНачните писать вашу статью здесь...\n\n## Основная часть\n\n## Заключение";
            $postData = ['meta' => ['title' => '']];
        }

        return $this->render('admin/edit_post', [
            'title' => $isNew ? 'Создать статью' : 'Редактирование статьи',
            'postSlug' => $postSlug,
            'content' => $content,
            'postData' => $postData,
            'isNew' => $isNew,
            'saved' => $saved
        ]);
    }

    public function editPage(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        // Получаем параметры из query string
        $queryParams = $request->getQueryParams();
        $pageName = $queryParams['page'] ?? '';
        $isNew = empty($pageName);

        // Инициализируем переменные
        $pageData = null;
        $content = '';
        $saved = false;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $pageName = Security::sanitizeInput($data['page_name'] ?? '');
            $title = Security::sanitizeInput($data['title'] ?? '');
            $content = $data['content'] ?? '';

            if ($pageName && $title && $content) {
                $frontMatter = "---\ntitle: \"{$title}\"\ndate: \"" . date('Y-m-d') . "\"\n---\n\n";
                $fullContent = $frontMatter . $content;

                if ($this->contentManager->savePage($pageName, $fullContent)) {
                    $saved = true;
                    return $this->redirect('/admin/edit_page?page=' . $pageName . '&saved=1');
                }
            }
        } else {
            // Для GET запроса проверяем параметр saved
            $saved = isset($queryParams['saved']);
        }

        // Загрузка данных для формы
        if ($pageName) {
            $pageData = $this->contentManager->getPage($pageName);
            $content = $pageData['raw_content'] ?? '';
        } else {
            $content = "## Заголовок\n\nНачните писать содержимое страницы здесь...";
            $pageData = ['meta' => ['title' => '']];
        }

        return $this->render('admin/edit_page', [
            'title' => $isNew ? 'Создать страницу' : 'Редактирование страницы',
            'pageName' => $pageName,
            'content' => $content,
            'pageData' => $pageData,
            'isNew' => $isNew,
            'saved' => $saved
        ]);
    }

    public function uploadMedia(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $message = null;
        $messageType = '';

        if ($request->getMethod() === 'POST') {
            $files = $request->getUploadedFiles();
            $file = $files['file'] ?? null;

            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $result = $this->fileUploader->handleUpload([
                    'name' => $file->getClientFilename(),
                    'type' => $file->getClientMediaType(),
                    'tmp_name' => $file->getStream()->getMetadata('uri'),
                    'error' => $file->getError(),
                    'size' => $file->getSize()
                ]);

                if ($result['success']) {
                    $message = 'Файл успешно загружен!';
                    $messageType = 'success';
                } else {
                    $message = $result['error'];
                    $messageType = 'error';
                }
            } else {
                $message = 'Ошибка загрузки файла';
                $messageType = 'error';
            }
        }

        $mediaFiles = $this->contentManager->getMediaFiles();

        return $this->render('admin/upload_media', [
            'title' => 'Загрузка медиафайлов',
            'icon' => 'images',
            'mediaFiles' => $mediaFiles,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }

    public function deletePost(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $queryParams = $request->getQueryParams();
        $postSlug = $queryParams['post'] ?? '';

        if ($postSlug) {
            $this->contentManager->deletePost($postSlug);
            return $this->redirect('/admin/manage_posts?deleted=1');
        }

        return $this->redirect('/admin/manage_posts');
    }

    public function deletePage(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $queryParams = $request->getQueryParams();
        $pageName = $queryParams['page'] ?? '';

        if ($pageName && !in_array($pageName, ['home', 'about', 'contact'])) {
            $this->contentManager->deletePage($pageName);
            return $this->redirect('/admin/manage_pages?deleted=1');
        }

        return $this->redirect('/admin/manage_pages');
    }

    public function managePosts(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $postsData = $this->contentManager->getAllPosts();

        return $this->render('admin/manage_posts', [
            'title' => 'Управление статьями',
            'icon' => 'newspaper',
            'posts' => $postsData
        ]);
    }

    public function managePages(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->checkAuth()) {
            return $this->redirect('/admin/login');
        }

        $pagesData = $this->contentManager->getAllPages();

        // Преобразуем данные для отображения
        $pages = [];
        foreach ($pagesData as $pageData) {
            $pages[] = [
                'name' => $pageData['slug'], // имя файла
                'title' => $pageData['meta']['title'] ?? $pageData['slug'] // заголовок из front matter
            ];
        }

        return $this->render('admin/manage_pages', [
            'title' => 'Управление страницами',
            'icon' => 'file',
            'pages' => $pages
        ]);
    }

    private function checkAuth(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        return true;
    }
}