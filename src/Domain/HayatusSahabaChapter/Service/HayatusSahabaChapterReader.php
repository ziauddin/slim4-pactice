<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterRepository;

/**
 * Service.
 */
final class HayatusSahabaChapterReader
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
     * Read a hayatusSahabaChapter.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     *
     * @return HayatusSahabaChapterData The hayatusSahabaChapter data
     */
    public function getHayatusSahabaChapterDataById(int $hayatusSahabaChapterId): HayatusSahabaChapterData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $hayatusSahabaChapter = $this->repository->getHayatusSahabaChapterById($hayatusSahabaChapterId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $hayatusSahabaChapter;
    }

    /**
     * Read a hayatusSahabaChapter.
     *
     * @param string $hayatusSahabaChapterName The hayatusSahabaChapter id
     *
     * @return array The hayatusSahabaChapter data getting by searching with chapter name
     */
    public function getHayatusSahabaChapterDataByName(string $hayatusSahabaChapterName): array
    {
        // Input validation
        // ...

        // Fetch data from the database
        $hayatusSahabaChapter = $this->repository->getHayatusSahabaChapterByName($hayatusSahabaChapterName);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $hayatusSahabaChapter;
    }
}
