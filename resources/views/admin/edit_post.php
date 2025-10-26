<div class="admin-header">
    <h1><?= $isNew ? '➕ Новая статья' : '✏️ Редактирование статьи' ?></h1>
    <a href="/admin.php?action=manage_posts" class="btn btn-secondary">← Назад</a>
</div>

<?php if (isset($saved) && $saved): ?>
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
                <strong>Подсказка по разметке:</strong><br>
                <code>## Заголовок</code> - заголовок<br>
                <code>**жирный**</code> - жирный текст<br>
                <code>*курсив*</code> - курсив<br>
                <code>- пункт</code> - список<br>
                <code>[текст](ссылка)</code> - ссылка
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
            
            <a href="/admin.php?action=manage_posts" class="btn btn-outline">Отмена</a>
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
    margin-top: 0.5rem;
    padding: 1rem;
    background: #f3f4f6;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #6b7280;
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

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    // Автогенерация slug из заголовка
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
});
</script>