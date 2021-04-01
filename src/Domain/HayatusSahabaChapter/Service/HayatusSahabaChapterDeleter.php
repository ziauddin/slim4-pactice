<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterRepository;

/**
 * Service.
 */
final class HayatusSahabaChapterDeleter
{
    private HayatusSahabaChapterRepository $repository;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterRepository $repository The repository
     */
    public function __construct(HayatusSahabaChapterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete hayatusSahabaChapter.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     *
     * @return void
     */
    public function deleteHayatusSahabaChapter(int $hayatusSahabaChapterId): void
    {
        // Input validation
        // ...

        $this->repository->deleteHayatusSahabaChapterById($hayatusSahabaChapterId);
    }
}
