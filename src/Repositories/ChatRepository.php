<?php

namespace GraveyardKeeperBot\Repositories;

use Doctrine\DBAL\Connection;

class ChatRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function saveStateByChatId(int $chatId, string $state): void
    {
        $sql = <<<SQL
INSERT INTO `graveyard`.`chats` SET `chat_id` = :chatId, `state` = :state
ON DUPLICATE KEY UPDATE `state` = :state, updated_at = :updatedAt
SQL;

        $this->connection->executeQuery($sql, [
            'chatId' => $chatId,
            'state' => $state,
            'updatedAt' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getStateByChatId(int $chatId): ?string
    {
        $sql = <<<SQL
SELECT `state` FROM `graveyard`.`chats`
WHERE `chat_id` = :chatId
SQL;

        $chat = $this->connection->fetchOne($sql, ['chatId' => $chatId]);

        return $chat ?: null;
    }
}
