<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Repository\KitabRepository;

/**
 * Service.
 */
final class KitabDeleter
{
    private KitabRepository $repository;

    /**
     * The constructor.
     *
     * @param KitabRepository $repository The repository
     */
    public function __construct(KitabRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete kitab.
     *
     * @param int $kitabId The kitab id
     *
     * @return void
     */
    public function deleteKitab(int $kitabId): void
    {
        // Input validation
        // ...

        $this->repository->deleteKitabById($kitabId);
    }
}
