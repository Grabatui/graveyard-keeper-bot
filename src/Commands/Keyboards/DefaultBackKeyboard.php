<?php

namespace GraveyardKeeperBot\Commands\Keyboards;

use GraveyardKeeperBot\Commands\BackCommand;
use JetBrains\PhpStorm\ArrayShape;

class DefaultBackKeyboard extends AbstractKeyboard
{
    #[ArrayShape([
        'keyboard' => "array[]",
        'resize_keyboard' => "bool",
        'one_time_keyboard' => "bool"
    ])]
    public function toArray(): array
    {
        return [
            'keyboard' => [
                [BackCommand::getTitle()],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }
}
