<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Repository\JiboniRepository;

/**
 * Service.
 */
final class JiboniDeleter
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
     * Delete jiboni.
     *
     * @param int $jiboniId The jiboni id
     *
     * @return void
     */
    public function deleteJiboni(int $jiboniId): void
    {
        // Input validation
        // ...

        $this->repository->deleteJiboniById($jiboniId);
    }
}