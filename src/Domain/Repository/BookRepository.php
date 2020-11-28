<?php

declare(strict_types=1);

namespace Domain\Repository;

use Domain\Entity\Book;

interface BookRepository
{
    /** @return Book[] */
    public function getAll(): array;
}
