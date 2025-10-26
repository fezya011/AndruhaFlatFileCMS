<?php
// Если контент содержит HTML (из MarkDown с HTML), рендерим как есть со стилями
if (isset($content['content']) && preg_match('/<[a-z][\s\S]*>/i', $content['content'])): 
?>
    <?= $content['content'] ?>
    
    <!-- Добавляем стили для главной страницы -->
    <style>
    /* Стили для навигационных кнопок */
    .main-nav {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 3rem 0;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .nav-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: 2rem 1.5rem;
        background: var(--gradient-card);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        text-decoration: none;
        color: var(--light-1);
        transition: all var(--transition-normal);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .nav-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.2), transparent);
        transition: left 0.6s;
    }

    .nav-btn:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg), var(--shadow-glow);
        border-color: var(--primary);
    }

    .nav-btn:hover::before {
        left: 100%;
    }

    .nav-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient-primary);
        border-radius: 50%;
        font-size: 1.5rem;
        transition: all var(--transition-normal);
    }

    .nav-btn:hover .nav-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .nav-btn span {
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Обновленные стили для блока с цифрами */
    .stats-counter {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
    }

    .stat-item {
        background: var(--gradient-card);
        padding: 2.5rem 1.5rem;
        border-radius: 20px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all var(--transition-normal);
        position: relative;
        overflow: hidden;
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .stat-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg), var(--shadow-glow);
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: var(--gradient-primary);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: var(--gradient-primary);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--light-3);
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Анимации */
    .animate-in {
        animation: fadeInUp 0.8s ease-out;
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .main-nav {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .stats-counter {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .stat-item {
            padding: 2rem 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .nav-btn {
            padding: 1.5rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .stats-counter {
            grid-template-columns: 1fr;
        }
        
        .main-nav {
            grid-template-columns: 1fr;
        }
    }
    </style>

<?php else: ?>
    <!-- Если это обычный MarkDown, рендерим через стандартный шаблон -->
    <div class="profile-card fade-in-up">
        <?= $content['content'] ?? 'Контент главной страницы не найден' ?>
        
        <?php if (!empty($posts)): ?>
        <div class="content-section">
            <h3><i class="fas fa-newspaper"></i> Последние статьи</h3>
            <div class="articles-grid">
                <?php foreach (array_slice($posts, 0, 3) as $post): ?>
                <div class="article-card">
                    <h3><?= htmlspecialchars($post['meta']['title'] ?? 'Без названия') ?></h3>
                    <div class="post-meta">
                        <span class="date"><i class="fas fa-calendar"></i> <?= $post['meta']['date'] ?? '' ?></span>
                    </div>
                    <div class="post-excerpt">
                        <?php
                        $content = strip_tags($post['content'] ?? '');
                        $excerpt = strlen($content) > 120 ? substr($content, 0, 120) . '...' : $content;
                        echo $excerpt;
                        ?>
                    </div>
                    <?php if (!empty($post['slug'])): ?>
                        <a href="/post/<?= $post['slug'] ?>" class="read-more">
                            <i class="fas fa-arrow-right"></i> Читать далее
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="/articles" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Все статьи
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php endif; ?>