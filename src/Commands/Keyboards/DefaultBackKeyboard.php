<?php

namespace GraveyardKeeperBot\Commands\Keyboards;

use GraveyardKeeperBot\Commands\BackCommand;

class DefaultBackKeyboard extends AbstractKeyboard
{
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
