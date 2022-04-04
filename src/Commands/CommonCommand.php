<?php

namespace GraveyardKeeperBot\Commands;

use DI\Container;
use GraveyardKeeperBot\Commands\Keyboards\DefaultBackKeyboard;
use GraveyardKeeperBot\Repositories\ChatRepository;
use Telegram\Bot\Commands\Command;

class CommonCommand extends Command
{
    public const NAME = 'common';

    private const COMMAND_ALIASES = [
        'назад' => BackCommand::NAME,
        'чертежи' => GetBlueprintCommand::NAME,
    ];

    private const COMMAND_DESCRIPTIONS = [
        GetBlueprintCommand::NAME => 'Введите полное название объекта или его часть',
    ];

    private const COMMANDS_WITHOUT_STATE = [
        BackCommand::NAME,
    ];

    public function __construct(
        private Container $container
    ) {
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function handle(): void
    {
        $text = mb_strtolower($this->getUpdate()->message->text);

        $chatId = $this->getUpdate()->getChat()->id;

        // Если ввели какой-то алиас (или выбрали из кнопки), запускаем начало команды - говорим какую-то
        // приветственную фразу и ждём дальнейших действий пользователя При этом пишем в базу состояние команды
        if (array_key_exists($text, static::COMMAND_ALIASES)) {
            $command = static::COMMAND_ALIASES[$text];

            $this->processCommandState($chatId, $command);

            return;
        }

        // Пытаемся проверить, что мы уже в "состоянии" какой-то команды. Значит, наконец, запускаем её
        $stateCommand = $this->getActualStateCommand($chatId);

        if ($stateCommand) {
            $this->triggerCommand($stateCommand);

            return;
        }

        // Если "состояние" не известно, падаем и переходим в "Старт"
        $this->replyWithMessage([
            'text' => 'К сожалению, я не понимаю что Вы хотите :С',
        ]);

        $this->triggerCommand(StartCommand::NAME);
    }

    private function processCommandState(int $chatId, string $commandName)
    {
        if (in_array($commandName, static::COMMANDS_WITHOUT_STATE)) {
            $this->triggerCommand($commandName);

            return;
        }

        $this->container->get(ChatRepository::class)->saveStateByChatId($chatId, $commandName);

        $this->replyWithMessage([
            'text' => static::COMMAND_DESCRIPTIONS[$commandName],
            'reply_markup' => DefaultBackKeyboard::toString(),
        ]);
    }

    private function getActualStateCommand(int $chatId): ?string
    {
        $state = $this->container->get(ChatRepository::class)->getStateByChatId($chatId);

        return $state && in_array($state, static::COMMAND_ALIASES) ? $state : null;
    }
}
