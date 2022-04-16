<?php

namespace GraveyardKeeperBot\Translations;

class Location
{
    private const MAP = [
        'yard' => 'Двор',
        'alchemical_laboratory' => 'Алхимическая лаборотория',
        'morgue' => 'Морг',
        'garden' => 'Сад',
        'basement' => 'Подвал',
        'crematorium' => 'Крематорий',
        'shed_in_woods' => 'Хижина в лесу',
        'vineyard' => 'Виноградник',
        'sweet_home' => 'Милый дом',
        'village' => 'Деревня',
        'career' => 'Карьер',
    ];

    public function get(string $code): string
    {
        return static::MAP[$code] ?? '';
    }
}
