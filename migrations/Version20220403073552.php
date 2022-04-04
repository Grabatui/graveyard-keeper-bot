<?php

declare(strict_types=1);

namespace GraveyardKeeperBot\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220403073552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE IF NOT EXISTS `graveyard`.`chats` (
    chat_id INT UNSIGNED PRIMARY KEY,
    state VARCHAR(20) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    updated_at DATETIME NOT NULL DEFAULT NOW()
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
DROP TABLE `graveyard`.`chats`;
SQL);
    }
}
