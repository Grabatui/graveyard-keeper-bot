<?php

namespace GraveyardKeeperBot\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    public const NAME = 'start';

    public function getName(): string
    {
        return static::NAME;
    }

    public function getDescription(): string
    {
        return 'Начало работы';
    }

    public function handle(): void
    {
        $this->replyWithMessage([
            'text' => 'Разделы, в которых ты можешь произвести поиск, представлены ниже',
            'reply_markup' => json_encode([
                'keyboard' => [
                    [GetBlueprintCommand::getTitle()],
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]),
        ]);
    }
}
