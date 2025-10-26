<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Панель управления' ?></title>
    
    <!-- Подключаем Font Awesome -->
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Основные стили админки -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --accent: #f72585;
            --success: #4cc9f0;
            --dark: #1a1a2e;
            --darker: #0f0f1a;
            --light: #f8f9fa;
            --gray: #6c757d;
            --gray-light: #adb5bd;
            --border: #e2e8f0;
            --sidebar: #1e293b;
            --sidebar-hover: #334155;
        }
        
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: #334155;
            line-height: 1.6;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--sidebar);
            color: white;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
            background: rgba(0,0,0,0.2);
        }
        
        .sidebar-header h2 {
            color: var(--success);
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .admin-sidebar nav ul {
            list-style: none;
            padding: 1rem 0;
        }
        
        .admin-sidebar nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 0.95rem;
        }
        
        .admin-sidebar nav a:hover {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: var(--success);
        }
        
        .admin-sidebar nav a.active {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary);
        }
        
        .admin-sidebar nav i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            background: #f8fafc;
            overflow-y: auto;
        }
        
        .admin-header {
            background: white;
            padding: 1.2rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .admin-header h1 {
            color: var(--dark);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-menu span {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        /* Content Area */
        .admin-content {
            padding: 2rem;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark);
            display: block;
            margin-bottom: 0.5rem;
            line-height: 1;
        }
        
        .stat-card h3 {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Buttons */
        .btn {
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-family: inherit;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #3ab9d8;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: var(--accent);
            color: white;
        }
        
        .btn-danger:hover {
            background: #e11571;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #64748b;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .card-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }
        
        .card-header h3 {
            color: var(--dark);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left-color: #10b981;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left-color: #ef4444;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            background: #f8fafc;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }
        
        .table tr:hover {
            background: #f8fafc;
        }
        
        .actions {
            display: flex;
            gap: 0.3rem;
        }
        
        /* Forms */
        .editor-form {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        textarea.form-control {
            min-height: 300px;
            resize: vertical;
            font-family: 'Courier New', monospace;
            line-height: 1.5;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        /* Empty states */
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                order: 2;
            }
            
            .admin-main {
                order: 1;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .admin-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .admin-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cogs"></i> Панель управления</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="/admin.php" class="<?= ($_GET['action'] ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Дашборд
                    </a></li>
                    <li><a href="/admin.php?action=manage_pages" class="<?= ($_GET['action'] ?? '') === 'manage_pages' ? 'active' : '' ?>">
                        <i class="fas fa-file"></i> Страницы
                    </a></li>
                    <li><a href="/admin.php?action=manage_posts" class="<?= ($_GET['action'] ?? '') === 'manage_posts' ? 'active' : '' ?>">
                        <i class="fas fa-newspaper"></i> Статьи
                    </a></li>
                    <li><a href="/admin.php?action=upload_media" class="<?= ($_GET['action'] ?? '') === 'upload_media' ? 'active' : '' ?>">
                        <i class="fas fa-images"></i> Медиа
                    </a></li>
                    <li><a href="/" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Посмотреть сайт
                    </a></li>
                    <li><a href="/admin.php?action=logout">
                        <i class="fas fa-sign-out-alt"></i> Выйти
                    </a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="admin-main">
            <div class="admin-header">
                <h1><i class="fas fa-<?= $icon ?? 'cog' ?>"></i> <?= $title ?? 'Панель управления' ?></h1>
                <div class="user-menu">
                    <span>Администратор</span>
                    <a href="/admin.php?action=logout" class="btn btn-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Выйти
                    </a>
                </div>
            </div>
            
            <div class="admin-content">
                <?php if (isset($saved) && $saved): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Изменения сохранены успешно!
                    </div>
                <?php endif; ?>
                
                <?php if (isset($deleted) && $deleted): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-trash"></i> Запись успешно удалена!
                    </div>
                <?php endif; ?>
                
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
    
    <script>
    function confirmDelete(message) {
        return confirm(message || 'Вы уверены, что хотите удалить эту запись?');
    }
    
    // Показ уведомлений
    function showAlert(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${message}`;
        document.querySelector('.admin-content').prepend(alert);
        
        setTimeout(() => alert.remove(), 5000);
    }
    </script>
</body>
</html>