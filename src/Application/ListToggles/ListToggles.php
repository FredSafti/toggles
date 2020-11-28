<?php

declare(strict_types=1);

namespace Application\ListToggles;

use Domain\Entity\Toggle;
use Domain\Repository\ToggleRepository;

class ListToggles
{
    private ToggleRepository $repository;

    public function __construct(ToggleRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @return Toggle[] */
    public function get(): array
    {
        return $this->repository->getAll();
    }
}
