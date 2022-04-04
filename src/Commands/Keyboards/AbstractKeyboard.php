<?php

namespace GraveyardKeeperBot\Commands\Keyboards;

abstract class AbstractKeyboard
{
    abstract public function toArray(): array;

    public static function toString(): string
    {
        return json_encode(
            (new static())->toArray()
        );
    }
}
