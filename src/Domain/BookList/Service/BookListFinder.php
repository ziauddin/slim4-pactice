<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Data\BookListData;
use App\Domain\BookList\Repository\BookListFinderRepository;

/**
 * Service.
 */
final class BookListFinder
{
    private BookListFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param BookListFinderRepository $repository The repository
     */
    public function __construct(BookListFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find chapterLists.
     *
     * @param array<mixed> $params The parameters
     *
     * @return BookListData[] A list of chapterLists
     */
    public function findBookLists(array $params): array
    {
        return $this->repository->findBookLists($params);
    }
}
