<?php
// Устанавливаем значения по умолчанию для переменных
$isNew = $isNew ?? true;
$postSlug = $postSlug ?? '';
$content = $content ?? '';
$postData = $postData ?? ['meta' => ['title' => '']];
$saved = $saved ?? false;
?>

<div class="admin-header">
    <h1><?= $isNew ? '➕ Новая статья' : '✏️ Редактирование статьи' ?></h1>
    <a href="/admin/manage_posts" class="btn btn-secondary">← Назад</a>
</div>

<?php if ($saved): ?>
    <div class="alert alert-success">✅ Статья сохранена!</div>
<?php endif; ?>

<div class="simple-form">
    <form method="POST">
        <div class="form-group">
            <label>Заголовок статьи *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($postData['meta']['title'] ?? '') ?>"
                   placeholder="Введите заголовок" required class="form-control">
        </div>

        <div class="form-group">
            <label>URL статьи *</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($postSlug ?: '') ?>"
                   placeholder="nazvanie-stati" pattern="[a-z0-9-]+" required
                   class="form-control" <?= !$isNew ? 'readonly' : '' ?>>
            <small>Только английские буквы, цифры и дефисы</small>
        </div>

        <div class="form-group">
            <label>Текст статьи *</label>
            <textarea name="content" rows="20" required placeholder="Напишите вашу статью здесь..."
                      class="form-control"><?= htmlspecialchars($content) ?></textarea>

            <div class="markdown-help">
                <strong>📝 Подсказка по разметке Markdown:</strong>
                <div class="help-examples">
                    <div class="help-item">
                        <span class="help-code"># Заголовок 1</span>
                        <span class="help-desc">- заголовок первого уровня</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">## Заголовок 2</span>
                        <span class="help-desc">- заголовок второго уровня</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">**жирный**</span>
                        <span class="help-desc">- жирный текст</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">*курсив*</span>
                        <span class="help-desc">- курсив</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">- пункт списка</span>
                        <span class="help-desc">- маркированный список</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">1. пункт</span>
                        <span class="help-desc">- нумерованный список</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">[текст](https://ссылка)</span>
                        <span class="help-desc">- ссылка</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">`встроенный код`</span>
                        <span class="help-desc">- код в строке</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">```php\nкод\n```</span>
                        <span class="help-desc">- блок кода с подсветкой</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">![Alt текст](/media/photo.jpg)</span>
                        <span class="help-desc">- изображение</span>
                    </div>
                    <div class="help-item">
                        <span class="help-code">> цитата</span>
                        <span class="help-desc">- блок цитаты</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 <?= $isNew ? 'Создать статью' : 'Сохранить' ?>
            </button>

            <?php if (!$isNew): ?>
                <a href="/post/<?= $postSlug ?>" target="_blank" class="btn btn-secondary">
                    👁️ Посмотреть на сайте
                </a>
            <?php endif; ?>

            <a href="/admin/manage_posts" class="btn btn-outline">Отмена</a>
        </div>
    </form>
</div>

<style>
    .simple-form {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    textarea.form-control {
        min-height: 400px;
        resize: vertical;
        font-family: 'Courier New', monospace;
        line-height: 1.5;
    }

    .markdown-help {
        margin-top: 1rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #4361ee;
    }


    .markdown-help code {
        background: #e5e7eb;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #6b7280;
    }

    .btn-outline:hover {
        background: #f9fafb;
    }

    .help-code {
        background: #e9ecef;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        min-width: 200px;
        margin-right: 1rem;
        border: 1px solid #dee2e6;
    }
    .help-desc {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .markdown-help strong {
        color: #4361ee;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }


    @media (max-width: 768px) {
        .help-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .help-code {
            margin-right: 0;
            margin-bottom: 0.3rem;
            min-width: auto;
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');

        // Автогенерация slug из заголовка
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                if (slugInput.value === '' || !slugInput.hasAttribute('readonly')) {
                    const slug = titleInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9а-яё\s]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/[а-яё]/g, function(char) {
                            const cyrToLat = {
                                'а':'a','б':'b','в':'v','г':'g','д':'d','е':'e','ё':'yo',
                                'ж':'zh','з':'z','и':'i','й':'y','к':'k','л':'l','м':'m',
                                'н':'n','о':'o','п':'p','р':'r','с':'s','т':'t','у':'u',
                                'ф':'f','х':'h','ц':'ts','ч':'ch','ш':'sh','щ':'sch','ъ':'',
                                'ы':'y','ь':'','э':'e','ю':'yu','я':'ya'
                            };
                            return cyrToLat[char] || char;
                        });
                    slugInput.value = slug;
                }
            });
        }
    });
</script>