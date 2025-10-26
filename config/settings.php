<?php

// Базовые пути
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', 'http://localhost:8000');

// Пути к данным
define('CONTENT_PATH', ROOT_PATH . '/content');
define('UPLOAD_PATH', ROOT_PATH . '/public/media/uploads');
define('TEMPLATE_PATH', ROOT_PATH . '/resources/views');
define('STORAGE_PATH', ROOT_PATH . '/storage');

// Настройки безопасности
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', password_hash('admin123', PASSWORD_DEFAULT));

// Настройки загрузки
define('MAX_FILE_SIZE', 5 * 1024 * 1024);
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// Создаем необходимые директории
$directories = [STORAGE_PATH . '/cache', STORAGE_PATH . '/logs', UPLOAD_PATH];
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Настройки ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);