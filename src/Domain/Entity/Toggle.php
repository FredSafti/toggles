<?php

declare(strict_types=1);

namespace Domain\Entity;

class Toggle
{
    public string $name;
    public bool $active;

    public function __construct(string $name, bool $active = false)
    {
        $this->name = $name;
        $this->active = $active;
    }
}
