<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Repository\HayatusSahabaFinderRepository;

/**
 * Service.
 */
final class HayatusSahabaFinder
{
    private HayatusSahabaFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param HayatusSahabaFinderRepository $repository The repository
     */
    public function __construct(HayatusSahabaFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find hayatusSahabas.
     *
     * @param array<mixed> $params The parameters
     *
     * @return array A list of hayatusSahabas
     */
    public function findHayatusSahabas(array $params): array
    {
        return $this->repository->findHayatusSahabas($params);
    }
}
