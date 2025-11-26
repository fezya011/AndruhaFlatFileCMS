<?php
// Устанавливаем значения по умолчанию для переменных
$isNew = $isNew ?? true;
$pageName = $pageName ?? '';
$content = $content ?? '';
$pageData = $pageData ?? ['meta' => ['title' => '']];
$saved = $saved ?? false;
?>

<div class="admin-header">
    <h1><?= $isNew ? '➕ Новая страница' : '✏️ Редактирование страницы' ?></h1>
    <a href="/admin/manage_pages" class="btn btn-secondary">← Назад</a>
</div>

<?php if ($saved): ?>
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

            <a href="/admin/manage_pages" class="btn btn-outline">Отмена</a>
        </div>
    </form>
</div>