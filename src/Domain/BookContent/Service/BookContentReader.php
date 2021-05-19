<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Data\BookContentData;
use App\Domain\BookContent\Repository\BookContentRepository;

/**
 * Service.
 */
final class BookContentReader
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
     * Read a bookContent.
     *
     * @param int $bookContentId The bookContent id
     *
     * @return BookContentData The bookContent data
     */
    public function getBookContentDataById(int $bookContentId): BookContentData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $bookContent = $this->repository->getBookContentById($bookContentId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $bookContent;
    }
}
