<?php

namespace Application\ListBooks;

use Domain\Repository\BookRepository;

class ListBooks
{
    // @toogle Release
    public const FEATURE_AVAILABLE = false;

    private BookRepository $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(): array
    {
        $list = array();
        foreach($this->repository->getAll() as $book) {
            $list[] = new Book($book->getId(), $book->getName());
        }

        return $list;
    }
}
