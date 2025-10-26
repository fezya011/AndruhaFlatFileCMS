<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-file"></i>
        </div>
        <h3>Страницы</h3>
        <div class="stat-number"><?= count($pages) ?></div>
        <a href="/admin.php?action=manage_pages" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i> Управлять
        </a>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <h3>Статьи</h3>
        <div class="stat-number"><?= count($posts) ?></div>
        <a href="/admin.php?action=manage_posts" class="btn btn-primary btn-sm">
            <i class="fas fa-edit"></i> Управлять
        </a>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-images"></i>
        </div>
        <h3>Медиафайлы</h3>
        <div class="stat-number"><?= count($mediaFiles) ?></div>
        <a href="/admin.php?action=upload_media" class="btn btn-primary btn-sm">
            <i class="fas fa-upload"></i> Загрузить
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-rocket"></i> Быстрые действия</h3>
    </div>
    <div class="card-body">
        <div class="quick-actions">
            <a href="/admin.php?action=edit_page&page=home" class="btn btn-primary">
                <i class="fas fa-edit"></i> Редактировать главную
            </a>
            <a href="/admin.php?action=edit_post" class="btn btn-success">
                <i class="fas fa-plus"></i> Добавить статью
            </a>
            <a href="/admin.php?action=upload_media" class="btn btn-secondary">
                <i class="fas fa-upload"></i> Загрузить файл
            </a>
            <a href="/" target="_blank" class="btn btn-secondary">
                <i class="fas fa-external-link-alt"></i> Посмотреть сайт
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Последние действия</h3>
    </div>
    <div class="card-body">
        <div class="empty-state">
            <i class="fas fa-info-circle"></i>
            <p>История действий будет отображаться здесь</p>
        </div>
    </div>
</div>