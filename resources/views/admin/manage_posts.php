<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-newspaper"></i> Управление статьями</h3>
        <a href="/admin/edit_post" class="btn btn-success">
            <i class="fas fa-plus"></i> Добавить статью
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($posts)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Статей пока нет</p>
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>URL</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($post['meta']['title'] ?? 'Без названия') ?></strong></td>
                        <td><code><?= htmlspecialchars($post['slug'] ?? '') ?></code></td>
                        <td><?= htmlspecialchars($post['meta']['date'] ?? '—') ?></td>
                        <td class="actions">
                            <a href="/admin/edit_post?post=<?= $post['slug'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/post/<?= $post['slug'] ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/delete_post?post=<?= $post['slug'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Удалить статью «<?= htmlspecialchars($post['meta']['title'] ?? '') ?>»?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>