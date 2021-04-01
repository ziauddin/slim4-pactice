<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Data\HayatusSahabaData;
use App\Domain\HayatusSahaba\Repository\HayatusSahabaRepository;

/**
 * Service.
 */
final class HayatusSahabaReader
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
     * Read a hayatusSahaba.
     *
     * @param int $hayatusSahabaId The hayatusSahaba id
     *
     * @return HayatusSahabaData The hayatusSahaba data
     */
    public function getHayatusSahabaDataById(int $hayatusSahabaId): HayatusSahabaData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $hayatusSahaba = $this->repository->getHayatusSahabaById($hayatusSahabaId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $hayatusSahaba;
    }
}
