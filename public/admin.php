<?php
// Начинаем буферизацию
ob_start();

require_once '../vendor/autoload.php';
require_once '../config/settings.php';

use App\Controllers\AdminController;

// Определяем действие
$action = $_GET['action'] ?? 'dashboard';

// Создаем контроллер админки
$adminController = new AdminController();

// Обрабатываем действие
switch ($action) {
    case 'login':
        $adminController->login();
        break;
    case 'logout':
        $adminController->logout();
        break;
    case 'edit_page':
        $adminController->editPage();
        break;
    case 'edit_post':
        $adminController->editPost();
        break;
    case 'upload_media':
        $adminController->uploadMedia();
        break;
    case 'delete_post':
        $adminController->deletePost();
        break;
    case 'delete_page':
        $adminController->deletePage();
        break;
    case 'manage_posts':
        $adminController->managePosts();
        break;
    case 'manage_pages':
        $adminController->managePages();
        break;
    case 'dashboard':
    default:
        $adminController->dashboard();
        break;
}

// Очищаем буфер
if (ob_get_level() > 0) {
    ob_end_flush();
}