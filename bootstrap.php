<?php

use DI\Container;
use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;
use GraveyardKeeperBot\Dumper;
use Telegram\Bot\Api;

include_once(__DIR__ . '/vendor/autoload.php');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);

/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

try {
    $container->set(
        Api::class,
        static fn(Container $container): Api => new Api($_SERVER['BOT_TOKEN'])
    );

    $connection = DriverManager::getConnection([
        'dbname' => $_SERVER['DB_DATABASE'],
        'user' => $_SERVER['DB_USERNAME'],
        'password' => $_SERVER['DB_PASSWORD'],
        'host' => $_SERVER['DB_HOST'],
        'driver' => 'pdo_mysql',
    ]);

    $container->set(Connection::class, $connection);
} catch (Exception $exception) {
    $container->get(Dumper::class)->exception($exception);
}
