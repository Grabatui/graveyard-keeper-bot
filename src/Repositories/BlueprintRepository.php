<?php

namespace GraveyardKeeperBot\Repositories;

use Doctrine\DBAL\Connection;
use GraveyardKeeperBot\Entities\Blueprint;
use GraveyardKeeperBot\Entities\Fields\Resource;

class BlueprintRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function search(string $searchString, int $limit = 3): array
    {
        $sql = <<<SQL
SELECT * FROM `graveyard`.`blueprints`
WHERE `name` LIKE :searchString
LIMIT $limit
SQL;

        $rawRows = $this->connection->fetchAllAssociative(
            $sql,
            ['searchString' => '%' . $searchString . '%']
        );

        return array_map(
            fn(array $raw): Blueprint => $this->makeEntity($raw),
            $rawRows
        );
    }

    private function makeEntity(array $raw): Blueprint
    {
        return new Blueprint(
            (int)$raw['id'],
            $raw['name'],
            $raw['description'],
            array_map(
                static fn(array $rawResource): Resource => new Resource(
                    $rawResource['code'],
                    (int)$rawResource['count']
                ),
                !empty($raw['resources']) ? json_decode($raw['resources'], true) : []
            ),
            (int)$raw['energy'],
            $raw['size'],
            !empty($raw['locations']) ? json_decode($raw['locations'], true) : []
        );
    }
}
