<?php

namespace GraveyardKeeperBot\Commands;

use Telegram\Bot\Commands\Command;

class BackCommand extends Command implements WithTitleInterface
{
    public const NAME = 'back';

    public static function getTitle(): string
    {
        return 'Назад';
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function handle()
    {
        $this->triggerCommand(StartCommand::NAME);
    }
}
