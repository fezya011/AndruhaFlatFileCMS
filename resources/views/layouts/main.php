<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Годованский Андрей - Веб-разработчик' ?></title>
    <meta name="description" content="<?= $description ?? 'Персональный блог Годованского Андрея о веб-разработке и программировании' ?>">
    
    <!-- ПОДКЛЮЧАЕМ СТИЛИ -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Дополнительные стили для админки -->
    <?php if (strpos($_SERVER['REQUEST_URI'] ?? '', 'admin.php') !== false): ?>
    <style>
        .admin-styles {
            :root {
                --primary: #4361ee;
                --secondary: #3f37c9;
                --success: #4cc9f0;
                --danger: #f72585;
                --warning: #f8961e;
                --dark: #1a1a2e;
                --light: #f8f9fa;
                --sidebar: #1e293b;
                --sidebar-hover: #334155;
            }
            
            .admin-container {
                display: flex;
                min-height: 100vh;
            }
            
            .admin-sidebar {
                width: 280px;
                background: var(--sidebar);
                color: white;
                padding: 0;
            }
            
            .admin-main {
                flex: 1;
                background: #f1f5f9;
            }
            
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }
            
            .stat-card {
                background: white;
                padding: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                border-left: 4px solid var(--primary);
            }
        </style>
    <?php endif; ?>
</head>
<body class="<?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', 'admin.php') !== false) ? 'admin-body' : ''; ?>">
    
    <?php if (strpos($_SERVER['REQUEST_URI'] ?? '', 'admin.php') === false): ?>
        <!-- Обычный хедер для сайта -->
        <header>
            <div class="container header-content">
                <a href="/" class="logo">Годованский Андрей</a>
                <nav>
                    <ul>
                        <li><a href="/" class="<?= ($_SERVER['REQUEST_URI'] ?? '/') === '/' ? 'active' : '' ?>">
                            <i class="fas fa-home"></i> Главная
                        </a></li>
                        <li><a href="/about" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/about' ? 'active' : '' ?>">
                            <i class="fas fa-user"></i> Обо мне
                        </a></li>
                        <li><a href="/articles" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/articles' ? 'active' : '' ?>">
                            <i class="fas fa-newspaper"></i> Статьи
                        </a></li>
                        <li><a href="/contact" class="<?= ($_SERVER['REQUEST_URI'] ?? '') === '/contact' ? 'active' : '' ?>">
                            <i class="fas fa-envelope"></i> Контакты
                        </a></li>
                        <?php if (\App\Core\Auth::check()): ?>
                        <li><a href="/admin.php" class="admin-link">
                            <i class="fas fa-cog"></i> Админка
                        </a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="container">
            <?= $content ?? '' ?>
        </main>

        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-info">
                        <h3>Годованский Андрей</h3>
                        <p>Начинающий веб-разработчик из Владивостока. Создаю современные и функциональные веб-приложения.</p>
                    </div>
                    <div class="footer-links">
                        <h4>Быстрые ссылки</h4>
                        <div class="social-links">
                            <a href="https://m.vk.com/veinsarempty"><i class="fab fa-vk"></i> VK</a>
                            <a href="https://t.me/pennoenjoyer"><i class="fab fa-telegram"></i> Telegram</a>
                            <a href="https://github.com/fezya011"><i class="fab fa-github"></i> GitHub</a>
                            <a href="mailto:agodovanskij@inbox.ru"><i class="fas fa-envelope"></i> Email</a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2025 Годованский Андрей. Сайт работает на собственной Flat-File CMS.</p>
                </div>
            </div>
        </footer>
    
    <?php else: ?>
        <!-- Контент админки -->
        <?= $content ?? '' ?>
    <?php endif; ?>

    <script>
    // Плавная прокрутка для якорей
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Анимация появления элементов при скролле
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.post-card, .card, .hero-section, .content-section').forEach(el => {
        observer.observe(el);
    });
    </script>
</body>
</html>