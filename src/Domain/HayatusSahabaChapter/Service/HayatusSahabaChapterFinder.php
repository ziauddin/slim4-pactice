<?php

namespace App\Domain\HayatusSahabaChapter\Service;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterFinderRepository;

/**
 * Service.
 */
final class HayatusSahabaChapterFinder
{
    private HayatusSahabaChapterFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterFinderRepository $repository The repository
     */
    public function __construct(HayatusSahabaChapterFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find hayatusSahabaChapters.
     *
     * @param array<mixed> $params The parameters
     *
     * @return HayatusSahabaChapterData[] A list of hayatusSahabaChapters
     */
    public function findHayatusSahabaChapters(array $params): array
    {
        return $this->repository->findHayatusSahabaChapters($params);
    }
}
