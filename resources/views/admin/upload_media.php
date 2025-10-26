<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-images"></i> Загрузка медиафайлов</h3>
    </div>
    <div class="card-body">
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?php if ($messageType === 'success'): ?>
                    <i class="fas fa-check-circle"></i>
                <?php else: ?>
                    <i class="fas fa-exclamation-circle"></i>
                <?php endif; ?>
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="upload-section">
            <div class="upload-form">
                <h4>Загрузить новый файл</h4>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Выберите файл:</label>
                        <input type="file" id="file" name="file" required 
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx" class="form-control">
                    </div>
                    
                    <div class="file-info">
                        <p><strong>Поддерживаемые форматы:</strong> JPG, PNG, GIF, PDF, DOC, DOCX</p>
                        <p><strong>Максимальный размер:</strong> 5MB</p>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Загрузить файл
                        </button>
                        <a href="/admin.php" class="btn btn-secondary">Назад в админку</a>
                    </div>
                </form>
            </div>
        </div>

        <?php if (!empty($mediaFiles)): ?>
        <div class="media-library" style="margin-top: 3rem;">
            <h4><i class="fas fa-photo-video"></i> Медиабиблиотека</h4>
            <div class="media-grid">
                <?php foreach ($mediaFiles as $file): ?>
                <div class="media-item">
                    <div class="media-preview">
                        <?php 
                        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <img src="<?= $file['url'] ?>" alt="<?= $file['name'] ?>" loading="lazy">
                        <?php elseif ($extension === 'pdf'): ?>
                            <i class="fas fa-file-pdf" style="color: #e74c3c;"></i>
                        <?php elseif (in_array($extension, ['doc', 'docx'])): ?>
                            <i class="fas fa-file-word" style="color: #2b579a;"></i>
                        <?php else: ?>
                            <i class="fas fa-file"></i>
                        <?php endif; ?>
                    </div>
                    <div class="media-info">
                        <span class="media-name" title="<?= $file['name'] ?>"><?= substr($file['name'], 0, 20) ?><?= strlen($file['name']) > 20 ? '...' : '' ?></span>
                        <span class="media-size"><?= round($file['size'] / 1024, 2) ?> KB</span>
                        <div class="media-actions">
                            <a href="<?= $file['url'] ?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-primary btn-sm copy-url" data-url="<?= $file['url'] ?>">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Медиафайлов пока нет</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.upload-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    margin-bottom: 2rem;
}

.upload-form h4 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.file-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    margin: 1rem 0;
    font-size: 0.9rem;
}

.file-info p {
    margin-bottom: 0.5rem;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.media-item {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.media-preview {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-bottom: 1px solid #e2e8f0;
}

.media-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    padding: 5px;
}

.media-preview i {
    font-size: 3rem;
    opacity: 0.7;
}

.media-info {
    padding: 1rem;
}

.media-name {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    word-break: break-all;
    font-size: 0.9rem;
}

.media-size {
    color: #64748b;
    font-size: 0.8rem;
    display: block;
    margin-bottom: 0.8rem;
}

.media-actions {
    display: flex;
    gap: 0.3rem;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #64748b;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}
</style>

<script>
// Функция для копирования URL в буфер обмена
document.querySelectorAll('.copy-url').forEach(button => {
    button.addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        const fullUrl = window.location.origin + url;
        
        navigator.clipboard.writeText(fullUrl).then(() => {
            // Временная смена иконки на "галочку"
            const originalIcon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i>';
            this.classList.add('btn-success');
            
            setTimeout(() => {
                this.innerHTML = originalIcon;
                this.classList.remove('btn-success');
            }, 2000);
        }).catch(err => {
            alert('Не удалось скопировать URL: ' + err);
        });
    });
});
</script>