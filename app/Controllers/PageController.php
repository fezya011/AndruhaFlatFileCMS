<?php

namespace App\Controllers;

use App\Core\Template;
use App\Core\Auth;
use App\Models\ContentManager;

class PageController
{
    private $template;
    private $contentManager;
    
    public function __construct()
    {
        $this->template = new Template();
        $this->contentManager = new ContentManager();
    }
    
    public function home()
    {
        try {
            $content = $this->contentManager->getPage('home');
            $posts = $this->contentManager->getAllPosts(3);
            
            if (!$content) {
                $content = $this->getDefaultHomeContent();
            }
            
             $this->template->render('home', [
                'content' => $content,
                'posts' => $posts,
                'title' => $content['meta']['title'] ?? 'Годованский Андрей - Веб-разработчик'
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }
    
    public function showPage($pageName)
    {
        try {
            $content = $this->contentManager->getPage($pageName);
            
            if (!$content) {
                return $this->show404();
            }
            
            $specialTemplates = ['about', 'contact', 'articles'];
            if (in_array($pageName, $specialTemplates)) {
                return $this->template->render($pageName, [
                    'content' => $content,
                    'title' => $content['meta']['title'] ?? ucfirst($pageName)
                ]);
            }
            
            $this->template->render('page', [
                'content' => $content,
                'title' => $content['meta']['title'] ?? ucfirst($pageName)
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }
    
    public function showArticles()
    {
        try {
            $posts = $this->contentManager->getAllPosts();
            
            $postsWithReadTime = [];
            foreach ($posts as $post) {
                $post['read_time'] = $this->calculateReadTime($post['content'] ?? '');
                $postsWithReadTime[] = $post;
            }
            
            $this->template->render('articles', [
                'posts' => $postsWithReadTime,
                'title' => 'Статьи - Годованский Андрей'
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }
    
    public function showPost($postSlug)
    {
        try {
            $post = $this->contentManager->getPost($postSlug);
            
            if (!$post) {
                return $this->show404();
            }
            
            $this->template->render('post', [
                'post' => $post,
                'title' => $post['meta']['title'] ?? 'Статья'
            ]);
        } catch (\Exception $e) {
            $this->showError($e->getMessage());
        }
    }
    
    private function calculateReadTime($content)
    {
        $text = strip_tags($content ?? '');
        $wordCount = str_word_count($text);
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }
    
    private function getDefaultHomeContent()
    {
        return [
            'meta' => [
                'title' => 'Годованский Андрей - Веб-разработчик',
                'description' => 'Персональный блог Годованского Андрея о веб-разработке и программировании'
            ],
            'content' => $this->getDefaultHomeHTML()
        ];
    }
    
    private function getDefaultHomeHTML()
    {
        return '
            <section class="hero-section fade-in-up">
                <div class="hero-content">
                    <h1>Годованский Андрей</h1>
                    <p class="subtitle">Начинающий веб-разработчик & IT-энтузиаст</p>
                    
                    <div class="main-nav">
                        <a href="/about" class="nav-btn">
                            <div class="nav-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Обо мне</span>
                        </a>
                        <a href="/articles" class="nav-btn">
                            <div class="nav-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <span>Статьи</span>
                        </a>
                        <a href="/contact" class="nav-btn">
                            <div class="nav-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span>Контакты</span>
                        </a>
                        ' . (Auth::check() ? '
                        <a href="/admin.php" class="nav-btn admin-btn">
                            <div class="nav-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span>Админка</span>
                        </a>' : '') . '
                    </div>
                </div>
            </section>

            <div class="profile-card animate-in">
                <div class="profile-header">
                    <h2>Привет! 👋</h2>
                    <div class="profile-tagline">Меня зовут Андрей, и я создаю цифровые решения</div>
                </div>

                <div class="stats-counter">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div class="stat-number">17</div>
                        <div class="stat-label">Лет</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="stat-number">2+</div>
                        <div class="stat-label">Года в IT</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="stat-number">5+</div>
                        <div class="stat-label">Технологий</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Проектов</div>
                    </div>
                </div>

                <div class="content-section">
                    <h3><i class="fas fa-rocket"></i> О себе</h3>
                    <p>Я начинающий веб-разработчик из Владивостока, увлеченный созданием современных и функциональных веб-приложений. Сейчас активно изучаю полный стек веб-разработки.</p>
                    
                    <div style="text-align: center; margin-top: 2rem;">
                        <a href="/about" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Узнать больше обо мне
                        </a>
                    </div>
                </div>
            </div>';
    }
    
    private function show404()
    {
        http_response_code(404);
        $this->template->render('404', [
            'title' => '404 - Страница не найдена'
        ]);
    }
    
    private function showError($message)
    {
        http_response_code(500);
        $this->template->render('error', [
            'title' => 'Ошибка',
            'message' => $message
        ]);
    }
}