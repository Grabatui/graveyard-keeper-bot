<?php

namespace GraveyardKeeperBot\Templates;

abstract class AbstractTemplate
{
    /**
     * @param string[] $rows
     * @return string
     */
    protected function makeString(array $rows): string
    {
        return implode(PHP_EOL, $rows);
    }

    protected function escapeText(string $text): string
    {
        return str_replace(
            ['-'],
            ['\-'],
            $text
        );
    }

    protected function boldText(string $text): string
    {
        return '*' . $text . '*';
    }

    protected function italicText(string $text): string
    {
        return '_' . $text . '_';
    }

    protected function strikeText(string $text): string
    {
        return '~' . $text . '~';
    }

    protected function codeText(string $text): string
    {
        return '`' . $text . '`';
    }

    protected function underlineText(string $text): string
    {
        return '__' . $text . '__';
    }
}
