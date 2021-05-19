<?php

namespace App\Domain\ChapterList\Service;

use App\Domain\ChapterList\Repository\ChapterListRepository;

/**
 * Service.
 */
final class ChapterListDeleter
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
     * Delete chapterList.
     *
     * @param int $chapterListId The chapterList id
     *
     * @return void
     */
    public function deleteChapterList(int $chapterListId): void
    {
        // Input validation
        // ...

        $this->repository->deleteChapterListById($chapterListId);
    }
}
