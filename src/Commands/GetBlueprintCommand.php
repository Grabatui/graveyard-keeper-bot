<?php

namespace GraveyardKeeperBot\Commands;

use DI\Container;
use GraveyardKeeperBot\Commands\Keyboards\DefaultBackKeyboard;
use GraveyardKeeperBot\Entities\Blueprint;
use GraveyardKeeperBot\Repositories\BlueprintRepository;
use GraveyardKeeperBot\Templates\BlueprintTemplate;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class GetBlueprintCommand extends Command implements WithTitleInterface
{
    public const NAME = 'blueprints';

    private const ARGUMENT_SEARCH_STRING = 'searchString';

    private const SEARCH_STRING_MIN_LENGTH = 2;
    private const BLUEPRINTS_SHOW_COUNT = 3;

    public function __construct(
        private Container $container
    ) {
        $this->setPattern(
            sprintf('{%s?}', static::ARGUMENT_SEARCH_STRING)
        );
    }

    public static function getTitle(): string
    {
        return 'Чертежи';
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function getDescription(): string
    {
        return 'Поиск по чертажам';
    }

    public function handle()
    {
        $searchString = $this->resolveSearchString();

        if (!$searchString) {
            $this->replyWithMessage([
                'text' => 'Нужно ввести поисковую строку!',
                'reply_markup' => DefaultBackKeyboard::toString(),
            ]);

            return;
        }

        if (mb_strlen($searchString) < static::SEARCH_STRING_MIN_LENGTH) {
            $this->replyWithMessage([
                'text' => 'Пожалуйста, введите не менее 2х символов!',
                'reply_markup' => DefaultBackKeyboard::toString(),
            ]);

            return;
        }

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // Достаём +1, чтобы сказать пользователю, что найдено слишком много
        $blueprints = $this->container
            ->get(BlueprintRepository::class)
            ->search($searchString, static::BLUEPRINTS_SHOW_COUNT + 1);

        if (empty($blueprints)) {
            $this->replyWithMessage([
                'text' => 'По вашему запросу ничего не найдено. Попробуйте ввести иначе',
                'reply_markup' => DefaultBackKeyboard::toString(),
            ]);

            return;
        }

        /** @var Blueprint $blueprint */
        foreach (array_slice($blueprints, 0, static::BLUEPRINTS_SHOW_COUNT) as $blueprint) {
            $this->replyWithMessage([
                'text' => $this->container->get(BlueprintTemplate::class)->get($blueprint),
                'reply_markup' => DefaultBackKeyboard::toString(),
                'parse_mode' => 'MarkdownV2',
            ]);
        }

        $this->replyWithMessage([
            'text' => count($blueprints) > static::BLUEPRINTS_SHOW_COUNT
                ? 'Найдено много подходящих вариантов. Попробуйте ввести запрос точнее'
                : 'Показаны все подходящие варианты',
            'reply_markup' => DefaultBackKeyboard::toString(),
        ]);
    }

    private function resolveSearchString(): string
    {
        $argumentSearchString = trim(
            $this->getArguments()[static::ARGUMENT_SEARCH_STRING] ?? ''
        );

        if (!empty($argumentSearchString)) {
            return $argumentSearchString;
        }

        return trim($this->getUpdate()->getMessage()->text);
    }
}
