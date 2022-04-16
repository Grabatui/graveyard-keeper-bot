<?php

namespace GraveyardKeeperBot\Entities\Fields;

class Resource
{
    private string $code;
    private string $count;

    public function __construct(
        string $code,
        string $count
    ) {
        $this->code = $code;
        $this->count = $count;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCount(): string
    {
        return $this->count;
    }
}
