<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Domain\VolumeList\Repository\VolumeListRepository;

/**
 * Service.
 */
final class VolumeListReader
{
    private VolumeListRepository $repository;

    /**
     * The constructor.
     *
     * @param VolumeListRepository $repository The repository
     */
    public function __construct(VolumeListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a volumeList.
     *
     * @param int $volumeListId The volumeList id
     *
     * @return VolumeListData The volumeList data
     */
    public function getVolumeListDataById(int $volumeListId): VolumeListData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $volumeList = $this->repository->getVolumeListById($volumeListId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $volumeList;
    }
}
