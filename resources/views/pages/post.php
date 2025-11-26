<?php
use App\Core\Auth;
// Устанавливаем значения по умолчанию
$post = $post ?? [];
$title = $title ?? 'Статья';
?>

<div class="card">
    <div class="card-header">
        <h1><?= htmlspecialchars($post['meta']['title'] ?? 'Статья') ?></h1>
        <?php if (isset($post['meta']['date'])): ?>
            <div class="post-meta">
                <i class="fas fa-calendar"></i>
                <?= date('d.m.Y', strtotime($post['meta']['date'])) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="post-content">
            <?= $post['content'] ?? '<p>Содержание статьи отсутствует.</p>' ?>
        </div>

        <div class="post-actions" style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
            <a href="/articles" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к статьям
            </a>

            <?php if (Auth::check()): ?>
                <a href="/admin/edit_post?post=<?= $post['slug'] ?? '' ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .post-content {
        line-height: 1.7;
        font-size: 1.1rem;
    }

    .post-content h1 {
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .post-content h2 {
        color: var(--dark);
        margin: 2rem 0 1rem 0;
    }

    .post-content h3 {
        color: var(--dark);
        margin: 1.5rem 0 1rem 0;
    }

    .post-content p {
        margin-bottom: 1.2rem;
        color: #4a5568;
    }

    .post-content ul, .post-content ol {
        margin: 1rem 0;
        padding-left: 2rem;
    }

    .post-content li {
        margin-bottom: 0.5rem;
    }

    .post-content code {
        background: #f7fafc;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #e53e3e;
    }

    .post-content pre {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
    }

    .post-content pre code {
        background: none;
        color: inherit;
        padding: 0;
    }

    .post-content blockquote {
        border-left: 4px solid var(--primary);
        padding-left: 1rem;
        margin: 1.5rem 0;
        color: #718096;
        font-style: italic;
    }

    .post-meta {
        color: #718096;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .post-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
</style>