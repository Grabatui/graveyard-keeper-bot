<?php

namespace GraveyardKeeperBot\Translations;

class Resource
{
    private const MAP = [
        'nail' => 'Гвозди',
        'simple_iron_detail' => 'Простые железные детали',
        'complex_iron_detail' => 'Сложные железные детали',
        'iron_bullion' => 'Железные слитки',
        'steel_bullion' => 'Слитки стали',
        'steel_part' => 'Стальные части',

        'stick' => 'Палки',
        'plank' => 'Доски',
        'good_plank' => 'Брус',
        'wooden_beam' => 'Деревянные балки',
        'chump' => 'Чурбаны',
        'wooden_structure' => 'Деревянные конструкции',

        'stone' => 'Куски камня',
        'polished_stone' => 'Полированный камень',

        'pigskin_paper' => 'Бумага из свиной кожи',
        'lens' => 'Линзы',
        'flask' => 'Колбы',
        'complex_flask' => 'Сложные колбы',
    ];

    public function get(string $code): string
    {
        return static::MAP[$code] ?? '';
    }
}
