<?php
// Улучшенный шаблон для страницы со статьями
?>
<div class="articles-page">
    <div class="profile-card fade-in-up">
        <div class="profile-header">
            <h1>📝 Мои статьи</h1>
            <p class="profile-tagline">Здесь я делюсь своими знаниями, опытом и мыслями о веб-разработке</p>
        </div>

        <!-- Статистика статей -->
        <div class="articles-stats">
            <div class="stat-item">
                <div class="stat-number"><?= count($posts) ?></div>
                <div class="stat-label">Всего статей</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= count($posts) > 0 ? date('Y', strtotime($posts[0]['meta']['date'] ?? '')) : '2024' ?></div>
                <div class="stat-label">Год первой статьи</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?= count($posts) > 0 ? date('Y', strtotime(end($posts)['meta']['date'] ?? '')) : '2024' ?></div>
                <div class="stat-label">Год последней статьи</div>
            </div>
        </div>
        
        <div class="articles-list">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $index => $post): 
                    $meta = [];
                    if (preg_match('/^---\s*\n(.*?)\n---/s', $post['content'] ?? '', $matches)) {
                        $lines = explode("\n", $matches[1]);
                        foreach ($lines as $line) {
                            if (strpos($line, ':') !== false) {
                                list($key, $value) = explode(':', $line, 2);
                                $meta[trim($key)] = trim(trim($value), '"\'');
                            }
                        }
                    }
                    
                    $slug = $post['slug'] ?? '';
                    $excerpt = strip_tags($post['content'] ?? '');
                    $excerpt = strlen($excerpt) > 150 ? substr($excerpt, 0, 150) . '...' : $excerpt;
                    
                    // Определяем иконку по индексу
                    $icons = ['📖', '✨', '🚀', '💡', '🎯', '🔥'];
                    $icon = $icons[$index % count($icons)];
                ?>
                <article class="article-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="article-badge">
                        <?= $icon ?>
                    </div>
                    
                    <div class="article-header">
                        <h3><?= htmlspecialchars($meta['title'] ?? 'Без названия') ?></h3>
                        <div class="article-meta">
                            <span class="date"><i class="fas fa-calendar"></i> <?= $meta['date'] ?? 'Не указана' ?></span>
                            <?php if (!empty($meta['author'])): ?>
                            <span class="author"><i class="fas fa-user"></i> <?= $meta['author'] ?></span>
                            <?php endif; ?>
                            <span class="read-time"><i class="fas fa-clock"></i> <?= $post['read_time'] ?? '3' ?> мин.</span>
                        </div>
                    </div>
                    
                    <div class="article-excerpt">
                        <?= $excerpt ?>
                    </div>
                    
                    <div class="article-tags">
                        <?php if (!empty($meta['tags'])): ?>
                            <?php $tags = explode(',', $meta['tags']); ?>
                            <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                                <span class="tag"><?= trim($tag) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="tag">Программирование</span>
                            <span class="tag">Веб-разработка</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($slug): ?>
                        <a href="/post/<?= $slug ?>" class="read-more-btn">
                            <span>Читать статью</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="read-more-btn disabled">
                            <span>Читать статью</span>
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-articles">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3>Статей пока нет</h3>
                        <p>Но скоро здесь появятся интересные материалы о веб-разработке и программировании!</p>
                        <?php if (\App\Core\Auth::check()): ?>
                            <a href="/admin.php?action=edit_post" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Написать первую статью
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Призыв к действию -->
        <?php if (!empty($posts)): ?>
        <div class="content-section text-center">
            <h2><i class="fas fa-rss"></i> Больше контента впереди!</h2>
            <p class="cta-text">Я постоянно учусь новому и делюсь своими находками. Возвращайтесь за новыми статьями!</p>
            <div class="cta-actions">
                <a href="/about" class="btn btn-secondary">
                    <i class="fas fa-user"></i> Узнать больше обо мне
                </a>
                <a href="/contact" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Предложить тему
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.articles-page {
    padding: 2rem 0;
}

/* Статистика статей */
.articles-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0 3rem 0;
}

.articles-stats .stat-item {
    background: var(--gradient-card);
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all var(--transition-normal);
}

.articles-stats .stat-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.articles-stats .stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: block;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.articles-stats .stat-label {
    color: var(--light-3);
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Список статей */
.articles-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.article-card {
    background: var(--gradient-card);
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-normal);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.article-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.article-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg), var(--shadow-glow);
}

.article-badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    font-size: 1.5rem;
    opacity: 0.7;
}

.article-header {
    margin-bottom: 1.5rem;
}

.article-card h3 {
    color: var(--light-1);
    margin-bottom: 1rem;
    font-size: 1.5rem;
    line-height: 1.3;
    padding-right: 3rem;
}

.article-meta {
    color: var(--light-3);
    font-size: 0.9rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.article-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.3rem 0.8rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.article-excerpt {
    color: var(--light-2);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 1.05rem;
}

.article-tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.tag {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-light);
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--gradient-primary);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all var(--transition-normal);
    border: none;
    cursor: pointer;
}

.read-more-btn:hover {
    transform: translateX(5px);
    box-shadow: var(--shadow-glow);
}

.read-more-btn.disabled {
    background: var(--dark-3);
    color: var(--light-3);
    cursor: not-allowed;
    opacity: 0.6;
}

.read-more-btn.disabled:hover {
    transform: none;
    box-shadow: none;
}

/* Состояние пустого списка */
.no-articles {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state {
    background: var(--gradient-card);
    padding: 4rem 2rem;
    border-radius: 20px;
    border: 2px dashed rgba(255, 255, 255, 0.2);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    background: var(--gradient-primary);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.empty-state h3 {
    color: var(--light-1);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.empty-state p {
    color: var(--light-3);
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* Призыв к действию */
.cta-text {
    font-size: 1.1rem;
    color: var(--light-2);
    line-height: 1.7;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Анимации */
[data-aos] {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

[data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* Адаптивность */
@media (max-width: 768px) {
    .articles-page {
        padding: 1rem 0;
    }
    
    .articles-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .article-card {
        padding: 2rem 1.5rem;
    }
    
    .article-card h3 {
        font-size: 1.3rem;
        padding-right: 0;
    }
    
    .article-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .article-badge {
        position: relative;
        top: auto;
        right: auto;
        margin-bottom: 1rem;
    }
    
    .empty-state {
        padding: 3rem 1.5rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .articles-stats {
        grid-template-columns: 1fr;
    }
    
    .articles-stats .stat-number {
        font-size: 2rem;
    }
}
</style>

<script>
// Простая реализация AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-aos-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('aos-animate');
                }, parseInt(delay));
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));
});
</script>