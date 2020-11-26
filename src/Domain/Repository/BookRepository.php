<?php

namespace Domain\Repository;

use Domain\Entity\Book;

interface BookRepository
{
    /** @return Book[] */
    public function getAll(): array;
}
