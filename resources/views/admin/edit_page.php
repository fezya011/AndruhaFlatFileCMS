<div class="admin-header">
    <h1><?= $isNew ? '➕ Новая страница' : '✏️ Редактирование страницы' ?></h1>
    <a href="/admin.php?action=manage_pages" class="btn btn-secondary">← Назад</a>
</div>

<?php if (isset($saved) && $saved): ?>
    <div class="alert alert-success">✅ Страница сохранена!</div>
<?php endif; ?>

<div class="simple-form">
    <form method="POST">
        <div class="form-group">
            <label>Название страницы *</label>
            <input type="text" name="page_name" value="<?= htmlspecialchars($pageName) ?>" 
                   placeholder="about, contact, services..." required 
                   class="form-control" <?= !$isNew ? 'readonly' : '' ?>>
            <small>Латинские буквы, будет использоваться в URL</small>
        </div>

        <div class="form-group">
            <label>Заголовок страницы *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($pageData['meta']['title'] ?? '') ?>" 
                   placeholder="О нас, Контакты и т.д." required class="form-control">
        </div>

        <div class="form-group">
            <label>Содержание страницы *</label>
            <textarea name="content" rows="20" required placeholder="Напишите содержимое страницы..." 
                      class="form-control"><?= htmlspecialchars($content) ?></textarea>
            
            <div class="markdown-help">
                <strong>Можно использовать разметку:</strong><br>
                <code>## Подзаголовок</code> - заголовок<br>
                <code>**жирный**</code> - выделение<br>
                <code>- пункт</code> - список<br>
                <code>[текст](ссылка)</code> - ссылка
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 <?= $isNew ? 'Создать страницу' : 'Сохранить' ?>
            </button>
            
            <?php if (!$isNew): ?>
                <a href="/<?= $pageName === 'home' ? '' : $pageName ?>" target="_blank" class="btn btn-secondary">
                    👁️ Посмотреть на сайте
                </a>
            <?php endif; ?>
            
            <a href="/admin.php?action=manage_pages" class="btn btn-outline">Отмена</a>
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