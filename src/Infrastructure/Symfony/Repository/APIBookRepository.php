<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Repository;

use Domain\Entity\Book;
use Domain\Repository\BookRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class APIBookRepository implements BookRepository
{
    private const BASE_URL = 'https://the-one-api.dev/v2';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAll(): array
    {
        $response = $this->client->request('GET', self::BASE_URL . '/book');
        $rawList = $response->toArray();

        $list = array();
        foreach ($rawList['docs'] as $rawBook) {
            $list[] = new Book($rawBook['_id'], $rawBook['name']);
        }

        return $list;
    }
}
