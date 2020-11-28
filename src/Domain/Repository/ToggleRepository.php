<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Entity\Toggle;

interface ToggleRepository
{
    /** @return Toggle[] */
    public function getAll(): array;

    public function get(string $name): Toggle;

    public function save(Toggle $toggle): void;
}
