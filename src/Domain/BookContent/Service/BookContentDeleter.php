<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Repository\BookContentRepository;

/**
 * Service.
 */
final class BookContentDeleter
{
    private BookContentRepository $repository;

    /**
     * The constructor.
     *
     * @param BookContentRepository $repository The repository
     */
    public function __construct(BookContentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete bookContent.
     *
     * @param int $bookContentId The bookContent id
     *
     * @return void
     */
    public function deleteBookContent(int $bookContentId): void
    {
        // Input validation
        // ...

        $this->repository->deleteBookContentById($bookContentId);
    }
}
