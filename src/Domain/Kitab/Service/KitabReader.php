<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Data\KitabData;
use App\Domain\Kitab\Repository\KitabRepository;

/**
 * Service.
 */
final class KitabReader
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
     * Read a kitab.
     *
     * @param int $kitabId The kitab id
     *
     * @return KitabData The kitab data
     */
    public function getKitabDataById(int $kitabId): KitabData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $kitab = $this->repository->getKitabById($kitabId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $kitab;
    }
}
