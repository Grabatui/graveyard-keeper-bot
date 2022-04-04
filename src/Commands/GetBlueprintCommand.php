<?php

namespace GraveyardKeeperBot\Commands;

use DI\Container;
use GraveyardKeeperBot\Commands\Keyboards\DefaultBackKeyboard;
use GraveyardKeeperBot\Repositories\BlueprintRepository;
use Telegram\Bot\Commands\Command;

class GetBlueprintCommand extends Command implements WithTitleInterface
{
    public const NAME = 'blueprints';

    private const ARGUMENT_SEARCH_STRING = 'searchString';

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

        $blueprints = $this->container->get(BlueprintRepository::class)->search($searchString);

        if (empty($blueprints)) {
            $this->replyWithMessage([
                'text' => 'По вашему запросу ничего не найдено. Попробуйте ввести иначе',
                'reply_markup' => DefaultBackKeyboard::toString(),
            ]);

            return;
        }

        // TODO
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
