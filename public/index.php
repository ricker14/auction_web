<?php

session_start();

require '../vendor/autoload.php';

$config = require 'config.php';
$app = new \Slim\App($config);

// Add DIC
$container = $app->getContainer();

// Register Twig
$container['twig'] = function () {
    $loader = new \Twig\Loader\FilesystemLoader('../App/Views/');
    $twig = new \Twig\Environment($loader, array(
        'cache' => false,
        'debug' => true
    ));
    $twig->addExtension(new Twig_Extension_Debug());
    return $twig;
};

$container['logger'] = function() {
    $logger = new \Monolog\Logger('auction');
    $file_handler = new \Monolog\Handler\StreamHandler('../support/log/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

// Register DB Connection
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

// Register routes
require __DIR__ . '/../App/Routes/AuctionRoutes.php';
require __DIR__ . '/../App/Routes/AdministrationRoutes.php';

$app->run();
