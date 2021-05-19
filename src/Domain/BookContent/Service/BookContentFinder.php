<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Data\BookContentData;
use App\Domain\BookContent\Repository\BookContentFinderRepository;

/**
 * Service.
 */
final class BookContentFinder
{
    private BookContentFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param BookContentFinderRepository $repository The repository
     */
    public function __construct(BookContentFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find chapterLists.
     *
     * @param array<mixed> $params The parameters
     *
     * @return BookContentData[] A list of chapterLists
     */
    public function findBookContents(array $params): array
    {
        return $this->repository->findBookContents($params);
    }
}
