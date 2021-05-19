<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Repository\VolumeListRepository;

/**
 * Service.
 */
final class VolumeListDeleter
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
     * Delete volumeList.
     *
     * @param int $volumeListId The volumeList id
     *
     * @return void
     */
    public function deleteVolumeList(int $volumeListId): void
    {
        // Input validation
        // ...

        $this->repository->deleteVolumeListById($volumeListId);
    }
}
