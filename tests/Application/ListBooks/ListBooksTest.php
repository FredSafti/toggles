<?php

declare(strict_types=1);

namespace Tests\Application\ListBooks;

use Application\ListBooks\Book as ListBooksBook;
use Application\ListBooks\ListBooks;
use Domain\Entity\Book;
use PHPUnit\Framework\TestCase;

class ListBooksTest extends TestCase
{
    private function createListBooksWithFixtures(): ListBooks
    {
        $repository = new FakeBookRepository();
        $repository->loadData([
            new Book('1', 'First'),
            new Book('2', 'Second'),
            new Book('3', 'Thrid'),
        ]);

        return new ListBooks($repository);
    }

    public function testEmptyList(): void
    {
        $listBooks = new ListBooks(new FakeBookRepository());

        $list = $listBooks->get();

        $this->assertIsArray($list);
        $this->assertEmpty($list);
    }

    public function testListIsArray(): void
    {
        $listBooks = $this->createListBooksWithFixtures();

        $list = $listBooks->get();

        $this->assertIsArray($list);
        $this->assertCount(3, $list);
    }

    public function testListElementContent(): void
    {
        $listBooks = $this->createListBooksWithFixtures();

        $list = $listBooks->get();

        $this->assertInstanceOf(ListBooksBook::class, $list[0]);
        $this->assertSame('1', $list[0]->id);
        $this->assertSame('Second', $list[1]->name);
    }
}
