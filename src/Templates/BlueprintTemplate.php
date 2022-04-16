<?php

namespace GraveyardKeeperBot\Templates;

use DI\Container;
use GraveyardKeeperBot\Entities\Blueprint;
use GraveyardKeeperBot\Translations\Location;
use GraveyardKeeperBot\Translations\Resource;

class BlueprintTemplate extends AbstractTemplate
{
    public function __construct(
        private Container $container
    ) {
    }

    public function get(Blueprint $blueprint): string
    {
        $rows = [
            $this->boldText($blueprint->getName()),
            '',
        ];

        $resourceTranslator = $this->container->get(Resource::class);
        $locationTranslator = $this->container->get(Location::class);

        foreach ($blueprint->getResources() as $resource) {
            $name = $resourceTranslator->get(
                $resource->getCode()
            );

            $rows[] = sprintf(
                '%s: %s',
                $this->underlineText($this->escapeText($name)),
                $this->escapeText($resource->getCount())
            );
        }

        $rows[] = '';
        $rows[] = implode(
            ', ',
            array_map(
                fn(string $code): string => $this->italicText(
                    $this->escapeText(
                        $locationTranslator->get($code)
                    )
                ),
                $blueprint->getLocations()
            )
        );

        return $this->makeString($rows);
    }
}
