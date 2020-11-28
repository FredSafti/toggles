<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use Application\ListBooks\ListBooks;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BooksController
{
    private ListBooks $list;

    public function __construct(ListBooks $list)
    {
        $this->list = $list;
    }

    public function __invoke(): Response
    {
        if (! ListBooks::FEATURE_AVAILABLE) {
            throw new NotFoundHttpException('Not found');
        }

        return new JsonResponse($this->list->get());
    }
}
