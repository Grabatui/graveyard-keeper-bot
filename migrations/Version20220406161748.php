<?php

declare(strict_types=1);

namespace GraveyardKeeperBot\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406161748 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
TRUNCATE TABLE `graveyard`.`blueprints`;
SQL);

        $blueprints = json_decode(
            file_get_contents(__DIR__ . '/data/blueprints.json'),
            true
        );

        foreach ($blueprints as $blueprint) {
            $sql = <<<SQL
INSERT INTO `graveyard`.`blueprints`
SET
    name = :name,
    resources = :resources,
    energy = :energy,
    size = :size,
    locations = :locations,
    description = :description;
SQL;

            $this->addSql($sql, [
                'name' => $blueprint['name'],
                'resources' => json_encode($blueprint['resources']),
                'energy' => $blueprint['energy'],
                'size' => $blueprint['size'],
                'locations' => json_encode($blueprint['locations']),
                'description' => $blueprint['description'],
            ]);
        }
    }

    public function down(Schema $schema): void
    {
    }
}
