<?php

// Простой автозагрузчик классов
spl_autoload_register(function ($class) {
    // Пространство имен App
    if (strpos($class, 'App\\') === 0) {
        $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            echo "Файл не найден: " . $file . "<br>";
        }
    }
});

