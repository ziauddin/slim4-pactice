<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Repository\HayatusSahabaRepository;

/**
 * Service.
 */
final class HayatusSahabaDeleter
{
    private HayatusSahabaRepository $repository;

    /**
     * The constructor.
     *
     * @param HayatusSahabaRepository $repository The repository
     */
    public function __construct(HayatusSahabaRepository $repository)
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
    public function deleteHayatusSahaba(int $kitabId): void
    {
        // Input validation
        // ...

        $this->repository->deleteHayatusSahabaById($kitabId);
    }
}
