<?php
// Шаблон для отдельной статьи
?>
<article class="single-post">
    <div class="post-header">
        <h1><?= htmlspecialchars($post['meta']['title'] ?? 'Без названия') ?></h1>
        
        <div class="post-meta">
            <?php if (!empty($post['meta']['date'])): ?>
                <span class="date"><i class="fas fa-calendar"></i> <?= $post['meta']['date'] ?></span>
            <?php endif; ?>
            
            <?php if (!empty($post['meta']['author'])): ?>
                <span class="author"><i class="fas fa-user"></i> <?= $post['meta']['author'] ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="post-content">
        <?= $post['content'] ?? '<p>Содержание статьи отсутствует.</p>' ?>
    </div>

    <footer class="post-footer">
        <a href="/articles" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Назад к списку статей
        </a>
        
        <div class="post-share">
            <span>Поделиться:</span>
            <a href="https://vk.com/share.php?url=<?= urlencode((BASE_URL ?? 'http://localhost:8000') . $_SERVER['REQUEST_URI']) ?>" 
               target="_blank" class="social-share vk">
                <i class="fab fa-vk"></i> VK
            </a>
            <a href="https://t.me/share/url?url=<?= urlencode((BASE_URL ?? 'http://localhost:8000') . $_SERVER['REQUEST_URI']) ?>" 
               target="_blank" class="social-share telegram">
                <i class="fab fa-telegram"></i> Telegram
            </a>
        </div>
    </footer>
</article>

<style>
.single-post {
    background: var(--gradient-card);
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    margin-top: 2rem;
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.post-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.post-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--gradient-primary);
    border-radius: 2px;
}

.post-header h1 {
    color: var(--light-1);
    font-size: 2.8rem;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    background: var(--gradient-primary);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.post-meta {
    color: var(--light-3);
    display: flex;
    justify-content: center;
    gap: 2rem;
    font-size: 1rem;
    flex-wrap: wrap;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.post-content {
    line-height: 1.8;
    color: var(--light-2);
    font-size: 1.15rem;
}

.post-content h2 {
    color: var(--light-1);
    margin: 3rem 0 1.5rem 0;
    font-size: 2rem;
    padding-top: 1rem;
    border-bottom: 2px solid var(--primary);
    padding-bottom: 0.5rem;
}

.post-content h3 {
    color: var(--light-1);
    margin: 2.5rem 0 1.2rem 0;
    font-size: 1.6rem;
}

.post-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.post-content ul, .post-content ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.post-content li {
    margin-bottom: 0.8rem;
    color: var(--light-2);
}

.post-content code {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
    color: var(--primary-light);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.post-content pre {
    background: var(--dark-2);
    color: var(--light-2);
    padding: 1.5rem;
    border-radius: 12px;
    overflow-x: auto;
    margin: 2rem 0;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: var(--shadow-md);
}

.post-content pre code {
    background: none;
    padding: 0;
    color: inherit;
    border: none;
}

.post-content blockquote {
    border-left: 4px solid var(--primary);
    padding-left: 1.5rem;
    margin: 2rem 0;
    color: var(--light-3);
    font-style: italic;
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 0 8px 8px 0;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 2rem 0;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.post-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    overflow: hidden;
}

.post-content table th,
.post-content table td {
    padding: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    text-align: left;
}

.post-content table th {
    background: rgba(255, 255, 255, 0.1);
    font-weight: 600;
    color: var(--light-1);
}

.post-footer {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.post-share {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.post-share span {
    color: var(--light-3);
    font-weight: 500;
}

.social-share {
    padding: 0.7rem 1.2rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all var(--transition-normal);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.social-share.vk {
    background: #4a76a8;
    color: white;
}

.social-share.telegram {
    background: #0088cc;
    color: white;
}

.social-share:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Адаптивность */
@media (max-width: 768px) {
    .single-post {
        padding: 2rem 1.5rem;
        margin-top: 1rem;
    }
    
    .post-header h1 {
        font-size: 2.2rem;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 0.8rem;
    }
    
    .post-footer {
        flex-direction: column;
        text-align: center;
    }
    
    .post-share {
        justify-content: center;
    }
    
    .post-content {
        font-size: 1.05rem;
    }
    
    .post-content h2 {
        font-size: 1.7rem;
    }
    
    .post-content h3 {
        font-size: 1.4rem;
    }
}

@media (max-width: 480px) {
    .single-post {
        padding: 1.5rem 1rem;
    }
    
    .post-header h1 {
        font-size: 1.8rem;
    }
    
    .social-share {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
    }
}
</style>