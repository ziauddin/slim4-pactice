<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Data\JiboniData;
use App\Domain\Jiboni\Repository\JiboniRepository;

/**
 * Service.
 */
final class JiboniReader
{
    private JiboniRepository $repository;

    /**
     * The constructor.
     *
     * @param JiboniRepository $repository The repository
     */
    public function __construct(JiboniRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a jiboni.
     *
     * @param int $jiboniId The jiboni id
     *
     * @return JiboniData The jiboni data
     */
    public function getJiboniDataById(int $jiboniId): JiboniData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $jiboni = $this->repository->getJiboniById($jiboniId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $jiboni;
    }
}
