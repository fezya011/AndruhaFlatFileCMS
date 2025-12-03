<?php
// Устанавливаем значения по умолчанию для переменных
$isNew = $isNew ?? true;
$postSlug = $postSlug ?? '';
$content = $content ?? '';
$postData = $postData ?? ['meta' => ['title' => '']];
$saved = $saved ?? false;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
            rel="stylesheet"
            href="/assets/easymde/easymde.min.css"
    />
    <script src="/assets/easymde/easymde.min.js.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
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
            <textarea name="content" id="my-text-area" rows="20" required placeholder="Напишите вашу статью здесь..."
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

    .help-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        padding: 0.3rem 0;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: background-color 0.2s;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
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

        .admin-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }

    /* Стили для кнопок редактора */
    .code-block-btn {
        color: #6b7280;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .code-block-btn:hover {
        background-color: #f3f4f6;
    }
</style>

<script>
    // Инициализация EasyMDE редактора
    const easymde = new EasyMDE({
        element: document.getElementById('my-text-area'),
        spellChecker: false,
        autosave: {
            enabled: false
        },
        placeholder: "Напишите вашу статью здесь...",
        toolbar: [
            {
                name: "codeBlock",
                action: function(editor) {
                    // Получаем выбранный текст
                    const selection = editor.codemirror.getSelection();

                    if (selection) {
                        // Если есть выделение - оборачиваем его в блок кода
                        const wrappedText = "```\n" + selection + "\n```";
                        editor.codemirror.replaceSelection(wrappedText);
                    } else {
                        // Если нет выделения - вставляем шаблон блока кода
                        const cursor = editor.codemirror.getCursor();
                        const line = editor.codemirror.getLine(cursor.line);

                        if (line.trim() === "") {
                            // Если пустая строка - вставляем полный блок
                            const template = "```\n// Ваш код здесь\n```";
                            editor.codemirror.replaceSelection(template);
                        } else {
                            // Если есть текст - оборачиваем всю строку
                            editor.codemirror.setSelection(
                                {line: cursor.line, ch: 0},
                                {line: cursor.line, ch: line.length}
                            );
                            const wrappedText = "```\n" + line + "\n```";
                            editor.codemirror.replaceSelection(wrappedText);
                        }
                    }

                    // Фокусируемся на редакторе
                    editor.codemirror.focus();
                },
                className: "fas fa-code",
                title: "Вставить блок кода"
            },
            {
                name: "quote",
                action: function(editor) {
                    // Получаем выбранный текст
                    const selection = editor.codemirror.getSelection();

                    if (selection) {
                        // Если есть выделение - добавляем > к каждой строке
                        const lines = selection.split('\n');
                        const quotedLines = lines.map(line => '> ' + line).join('\n');
                        editor.codemirror.replaceSelection(quotedLines);
                    } else {
                        // Если нет выделения - вставляем шаблон цитаты
                        const cursor = editor.codemirror.getCursor();
                        const line = editor.codemirror.getLine(cursor.line);

                        if (line.trim() === "") {
                            // Если пустая строка - вставляем полную цитату
                            const template = "> Ваша цитата здесь";
                            editor.codemirror.replaceSelection(template);
                        } else {
                            // Если есть текст - добавляем > к строке
                            editor.codemirror.setSelection(
                                {line: cursor.line, ch: 0},
                                {line: cursor.line, ch: line.length}
                            );
                            const quotedLine = '> ' + line;
                            editor.codemirror.replaceSelection(quotedLine);
                        }
                    }

                    // Фокусируемся на редакторе
                    editor.codemirror.focus();
                },
                className: "fas fa-quote-right",
                title: "Вставить цитату"
            },
            '|',
            'bold', 'italic', 'heading', '|',
            'quote', 'unordered-list', 'ordered-list', '|',
            'link', 'image', '|',
            'preview', 'side-by-side', 'fullscreen', '|',
            'guide'
        ],
        renderingConfig: {
            codeSyntaxHighlighting: true
        }
    });

    // Автогенерация slug из заголовка
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');

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
</body>
</html>