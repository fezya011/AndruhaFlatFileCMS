<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file"></i> Управление страницами</h3>
        <a href="/admin.php?action=edit_page" class="btn btn-success">
            <i class="fas fa-plus"></i> Добавить страницу
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($pages)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Страниц пока нет</p>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Заголовок</th>
                        <th>URL</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($page['name']) ?></strong></td>
                        <td><?= htmlspecialchars($page['title']) ?></td>
                        <td><code>/<?= $page['name'] === 'home' ? '' : $page['name'] ?></code></td>
                        <td class="actions">
                            <a href="/admin.php?action=edit_page&page=<?= $page['name'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/<?= $page['name'] === 'home' ? '' : $page['name'] ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if (!in_array($page['name'], ['home', 'about', 'contact'])): ?>
                            <a href="/admin.php?action=delete_page&page=<?= $page['name'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Удалить страницу «<?= htmlspecialchars($page['title']) ?>»?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(message) {
    return confirm(message || 'Вы уверены, что хотите удалить эту запись?');
}
</script>