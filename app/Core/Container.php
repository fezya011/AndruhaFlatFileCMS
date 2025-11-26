<?php

namespace App\Core;

use League\Container\Container as LeagueContainer;
use App\Controllers\AdminController;
use App\Controllers\PageController;
use App\Models\ContentManager;
use App\Services\FileUploader;

class Container
{
    private static $instance;
    private $container;

    private function __construct()
    {
        $this->container = new LeagueContainer();
        $this->registerServices();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function registerServices(): void
    {
        // Регистрируем сервисы
        $this->container->add(Template::class);
        $this->container->add(ContentParser::class);

        // ContentManager должен получать ContentParser как зависимость
        $this->container->add(ContentManager::class)
            ->addArgument(ContentParser::class);

        $this->container->add(FileUploader::class);

        // Контроллеры
        $this->container->add(AdminController::class)
            ->addArguments([Template::class, ContentManager::class, FileUploader::class]);

        $this->container->add(PageController::class)
            ->addArguments([Template::class, ContentManager::class]);
    }

    public function get(string $class): object
    {
        return $this->container->get($class);
    }

    public function has(string $class): bool
    {
        return $this->container->has($class);
    }

    public function getContainer(): LeagueContainer
    {
        return $this->container;
    }
}