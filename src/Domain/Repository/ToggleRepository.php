<?php

namespace Domain\Repository;

use Domain\Entity\Toggle;

interface ToggleRepository
{
    public function get(string $name): Toggle;

    public function save(Toggle $toggle): void;
}
