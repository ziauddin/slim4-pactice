<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Domain\VolumeList\Repository\VolumeListFinderRepository;

/**
 * Service.
 */
final class VolumeListFinder
{
    private VolumeListFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param VolumeListFinderRepository $repository The repository
     */
    public function __construct(VolumeListFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find chapterLists.
     *
     * @param array<mixed> $params The parameters
     *
     * @return VolumeListData[] A list of chapterLists
     */
    public function findVolumeLists(array $params): array
    {
        return $this->repository->findVolumeLists($params);
    }
}
