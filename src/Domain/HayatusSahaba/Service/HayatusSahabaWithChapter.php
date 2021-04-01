<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Repository\HayatusSahabaFinderRepository;
use App\Domain\HayatusSahabaChapter\Repository\HayatusSahabaChapterFinderRepository;

/**
 * Service.
 */
final class HayatusSahabaWithChapter
{
    private HayatusSahabaFinderRepository $sahabaRepository;
    private HayatusSahabaChapterFinderRepository $sahabaChapterRepository;

    /**
     * The constructor.
     *
     * @param HayatusSahabaFinderRepository $srepository The sahaba repository
     * @param HayatusSahabaChapterFinderRepository $crepository The chapter repository
     */
    public function __construct(HayatusSahabaFinderRepository $srepository, HayatusSahabaChapterFinderRepository $crepository)
    {
        $this->sahabaRepository = $srepository;
        $this->sahabaChapterRepository = $crepository;
    }

    /**
     * Read all hayatusSahaba and chapter.
     *
     * @param mixed $params The filters array
     *
     * @return array $result
     */
    public function getAllHayatusSahabaChapter($params): array
    {
        // get all data off
        // ...

        $result = [];

        // Fetch data from the database
        $result['hayatusSahabas'] = $this->sahabaRepository->findHayatusSahabas($params);

        // Optional: Add or invoke your complex business logic here
        // ...

        $result['hayatusSahabaChapters'] = $this->sahabaChapterRepository->findHayatusSahabaChapters($params);

        // Optional: Map result
        // ...

        return $result;
    }
}
