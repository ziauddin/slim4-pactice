<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Data\ChapterListData;
use App\Domain\ChapterList\Repository\ChapterListFinderRepository;

/**
 * Service.
 */
final class ChapterListFinder
{
    private ChapterListFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param ChapterListFinderRepository $repository The repository
     */
    public function __construct(ChapterListFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find chapterLists.
     *
     * @param array<mixed> $params The parameters
     *
     * @return ChapterListData[] A list of chapterLists
     */
    public function findChapterLists(array $params): array
    {
        return $this->repository->findChapterLists($params);
    }
}
