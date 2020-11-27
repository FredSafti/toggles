<?php

namespace Tests\Application\SwitchToggle;

use Domain\Entity\Toggle;
use Domain\Repository\ToggleRepository;

class FakeToggleRepository implements ToggleRepository
{
    private array $collection = array();

    public function getAll(): array
    {
        return $this->collection;
    }

    public function get(string $name): Toggle
    {
        if (! isset($this->collection[$name])) {
            $this->collection[$name] = new Toggle($name);
        }

        return $this->collection[$name];
    }

    public function save(Toggle $toggle): void
    {
        $this->collection[$toggle->name] = $toggle;
    }
}
