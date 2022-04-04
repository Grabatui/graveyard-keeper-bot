<?php

use DI\Container;
use GraveyardKeeperBot\Commands\BackCommand;
use GraveyardKeeperBot\Commands\GetBlueprintCommand;
use GraveyardKeeperBot\Commands\CommonCommand;
use GraveyardKeeperBot\Commands\StartCommand;
use GraveyardKeeperBot\Dumper;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\HelpCommand;

include_once('../bootstrap.php');

/** @var Container $container */

try {
    $telegram = $container->get(Api::class);

    $container->get(Dumper::class)->debug(
        file_get_contents('php://input')
    );

    $telegram->addCommands([
        HelpCommand::class,
        StartCommand::class,
        BackCommand::class,
        new GetBlueprintCommand($container),
        new CommonCommand($container),
    ]);

    $update = $telegram->commandsHandler(true);

    if (!$update->getMessage()->has('entities')) {
        $telegram->triggerCommand(CommonCommand::NAME, $update);
    }
} catch (Exception $exception) {
    $container->get(Dumper::class)->exception($exception);
}
