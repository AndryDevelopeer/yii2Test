<?php
    require __DIR__ . '/../vendor/autoload.php';

    use app\commands\DownloadController;
    use app\controllers\commands\CatalogCommands;
    use Symfony\Component\Console\Application;

    $app = new Application();
    $app->add(new DownloadController());
    $app->run();