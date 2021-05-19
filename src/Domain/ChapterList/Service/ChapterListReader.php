<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Data\ChapterListData;
use App\Domain\ChapterList\Repository\ChapterListRepository;

/**
 * Service.
 */
final class ChapterListReader
{
    private ChapterListRepository $repository;

    /**
     * The constructor.
     *
     * @param ChapterListRepository $repository The repository
     */
    public function __construct(ChapterListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a chapterList.
     *
     * @param int $chapterListId The chapterList id
     *
     * @return ChapterListData The chapterList data
     */
    public function getChapterListDataById(int $chapterListId): ChapterListData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $chapterList = $this->repository->getChapterListById($chapterListId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $chapterList;
    }
}
