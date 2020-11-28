<?php

declare(strict_types=1);

namespace Tests\Application\ListBooks;

use Domain\Repository\BookRepository;

class FakeBookRepository implements BookRepository
{
    private $list = array();

    public function getAll(): array
    {
        return $this->list;
    }

    public function loadData(array $list): void
    {
        $this->list = array_merge($this->list, $list);
    }
}
