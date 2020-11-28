<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Command;

use Application\ListBooks\ListBooks;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BooksCommand extends Command
{
    private ListBooks $list;

    public function __construct(ListBooks $list)
    {
        $this->list = $list;

        parent::__construct('app:books');
    }

    public function isEnabled(): bool
    {
        return ListBooks::FEATURE_AVAILABLE;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $books = $this->list->get();
        if (empty($books)) {
            $io->note('Aucun bouquin');
            return Command::SUCCESS;
        }

        $io->table(array_keys($books[0]), $books);

        return Command::SUCCESS;
    }
}
