<?php

namespace GraveyardKeeperBot\Entities;

use GraveyardKeeperBot\Entities\Fields\Location;
use GraveyardKeeperBot\Entities\Fields\Resource;

class Blueprint
{
    private int $id;
    private string $name;
    private ?string $description;
    /**
     * @var Resource[]
     */
    private array $resources;
    private int $energy;
    private string $size;
    /**
     * @var string[]
     */
    private array $locations;

    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @param Resource[] $resources
     * @param int $energy
     * @param string $size
     * @param string[] $locations
     */
    public function __construct(
        int $id,
        string $name,
        ?string $description,
        array $resources,
        int $energy,
        string $size,
        array $locations
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->resources = $resources;
        $this->energy = $energy;
        $this->size = $size;
        $this->locations = $locations;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getEnergy(): int
    {
        return $this->energy;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getLocations(): array
    {
        return $this->locations;
    }
}
