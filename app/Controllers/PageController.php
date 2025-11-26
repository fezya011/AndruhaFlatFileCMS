<?php

namespace App\Controllers;

use App\Core\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController extends BaseController
{
    public function home(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $content = $this->contentManager->getPage('home');
            $posts = $this->contentManager->getAllPosts(3);

            if (!$content) {
                $content = $this->getDefaultHomeContent();
            }

            return $this->render('home', [
                'content' => $content,
                'posts' => $posts,
                'title' => $content['meta']['title'] ?? 'Годованский Андрей - Веб-разработчик'
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }

    public function showAbout(ServerRequestInterface $request): ResponseInterface
    {
        return $this->showSpecificPage('about');
    }

    public function showContact(ServerRequestInterface $request): ResponseInterface
    {
        return $this->showSpecificPage('contact');
    }

    public function showArticles(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $posts = $this->contentManager->getAllPosts();

            $postsWithReadTime = [];
            foreach ($posts as $post) {
                $post['read_time'] = $this->calculateReadTime($post['content'] ?? '');
                $postsWithReadTime[] = $post;
            }

            return $this->render('articles', [
                'posts' => $postsWithReadTime,
                'title' => 'Статьи - Годованский Андрей'
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }

    public function showPost(ServerRequestInterface $request, array $args): ResponseInterface
    {
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        echo '<pre>';print_r($request->getAttribute('slug'));echo '</pre>';exit();
        // +++++++++++++++++++++++++++++++++++++++++++++
        try {
            $route = $request->getAttribute('route');
            $postSlug = '';

            if ($route) {
                $routeArgs = $route->getVars();
                $postSlug = $routeArgs['slug'] ?? '';
            }

            if (empty($postSlug)) {
                error_log("Empty post slug!");
                return $this->show404();
            }

            error_log("Getting post from ContentManager: " . $postSlug);
            $post = $this->contentManager->getPost($postSlug);

            if (!$post) {
                error_log("Post not found in ContentManager: " . $postSlug);
                return $this->show404();
            }

            error_log("Post found, title: " . ($post['meta']['title'] ?? 'NO TITLE'));

            return $this->render('post', [
                'post' => $post,
                'title' => $post['meta']['title'] ?? 'Статья'
            ]);
        } catch (\Exception $e) {
            error_log("Error in showPost: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return $this->showError($e->getMessage());
        }
    }
    public function showPage(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $route = $request->getAttribute('route');
            $pageName = $route ? ($route->getVars()['page'] ?? '') : '';


            if ($pageName === 'post' || $pageName === 'posts') {
                return $this->show404();
            }


            if (empty($pageName) || $pageName === '/') {
                return $this->redirect('/');
            }

            $reserved = ['admin', 'api', 'assets', 'media', 'vendor', 'about', 'articles', 'contact', 'debug'];
            if (in_array($pageName, $reserved)) {
                return $this->show404();
            }

            $content = $this->contentManager->getPage($pageName);
            if (!$content) {
                return $this->show404();
            }

            return $this->render('page', [
                'content' => $content,
                'title' => $content['meta']['title'] ?? ucfirst($pageName)
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }

    private function showSpecificPage(string $pageName): ResponseInterface
    {
        try {
            $content = $this->contentManager->getPage($pageName);

            if (!$content) {
                return $this->show404();
            }

            return $this->render($pageName, [
                'content' => $content,
                'title' => $content['meta']['title'] ?? ucfirst($pageName)
            ]);
        } catch (\Exception $e) {
            return $this->showError($e->getMessage());
        }
    }

    private function calculateReadTime($content): int
    {
        $text = strip_tags($content ?? '');
        $wordCount = str_word_count($text);
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }

    private function getDefaultHomeContent(): array
    {
        return [
            'meta' => [
                'title' => 'Годованский Андрей - Веб-разработчик',
                'description' => 'Персональный блог Годованского Андрея о веб-разработке и программировании'
            ],
            'content' => $this->getDefaultHomeHTML()
        ];
    }

    private function getDefaultHomeHTML(): string
    {
        // ... тот же HTML код что и раньше
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
                        <a href="/admin" class="nav-btn admin-btn">
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

    private function show404(): ResponseInterface
    {
        return $this->render('404', [
            'title' => '404 - Страница не найдена'
        ])->withStatus(404);
    }

    private function showError(string $message): ResponseInterface
    {
        return $this->render('error', [
            'title' => 'Ошибка',
            'message' => $message
        ])->withStatus(500);
    }
}