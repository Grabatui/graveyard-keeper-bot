<?php

namespace GraveyardKeeperBot\Entities\Fields;

class Resource
{
    private string $code;
    private int $count;

    public function __construct(
        string $code,
        int $count
    ) {
        $this->code = $code;
        $this->count = $count;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
