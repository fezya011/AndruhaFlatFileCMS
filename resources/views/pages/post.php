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
        color: #e2e8f0; /* Светло-серый для основного текста */
    }

    .post-content h1 {
        color: #ffffff; /* Белый для заголовков */
        margin-bottom: 1rem;
    }

    .post-content h2 {
        color: #f7fafc; /* Очень светлый серый */
        margin: 2rem 0 1rem 0;
    }

    .post-content h3 {
        color: #edf2f7; /* Светлый серый */
        margin: 1.5rem 0 1rem 0;
    }

    .post-content p {
        margin-bottom: 1.2rem;
        color: #e2e8f0; /* Светло-серый */
    }

    .post-content ul, .post-content ol {
        margin: 1rem 0;
        padding-left: 2rem;
        color: #e2e8f0; /* Светло-серый */
    }

    .post-content li {
        margin-bottom: 0.5rem;
    }

    .post-content code {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #ff79c6;
    }

    .post-content pre {
        background: #1a1a1a;
        color: #f8f8f2;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
        border: 1px solid #333;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .post-content pre code {
        background: none;
        padding: 0;
        color: inherit;
    }


    .post-content blockquote {
        border-left: 4px solid var(--primary);
        padding-left: 1rem;
        margin: 1.5rem 0;
        color: #cbd5e0; /* Средний серый для цитат */
        font-style: italic;
        background: rgba(255, 255, 255, 0.05);
        padding: 1rem;
        border-radius: 0 8px 8px 0;
    }

    .post-meta {
        color: #a0aec0; /* Серый для мета-информации */
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .post-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Стили для ссылок в контенте */
    .post-content a {
        color: #90cdf4; /* Светло-голубой для ссылок */
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: all 0.3s;
    }

    .post-content a:hover {
        color: #63b3ed; /* Ярче при наведении */
        border-bottom-color: #63b3ed;
    }

    /* Улучшаем читаемость сильных элементов */
    .post-content strong {
        color: #ffffff; /* Белый для жирного текста */
    }

    .post-content em {
        color: #e2e8f0; /* Светло-серый для курсива */
    }

    .language-csharp .keyword { color: #ff79c6; }
    .language-csharp .type { color: #8be9fd; }
    .language-csharp .string { color: #f1fa8c; }
    .language-csharp .comment { color: #6272a4; }
    .language-csharp .number { color: #bd93f9; }

    .language-php .keyword { color: #ff79c6; }
    .language-php .function { color: #50fa7b; }
    .language-php .string { color: #f1fa8c; }
    .language-php .comment { color: #6272a4; }

    .language-javascript .keyword { color: #ff79c6; }
    .language-javascript .function { color: #50fa7b; }
    .language-javascript .string { color: #f1fa8c; }
</style>