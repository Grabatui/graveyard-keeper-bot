<?php

declare(strict_types=1);

namespace GraveyardKeeperBot\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220404161922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE IF NOT EXISTS `graveyard`.`blueprints` (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL DEFAULT NULL,
    resources JSON NOT NULL,
    energy INT UNSIGNED NOT NULL,
    size VARCHAR(10) NOT NULL,
    locations JSON NOT NULL
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
DROP TABLE `graveyard`.`blueprints`;
SQL);
    }
}
