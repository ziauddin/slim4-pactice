<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Data\KitabData;
use App\Domain\Kitab\Repository\KitabFinderRepository;

/**
 * Service.
 */
final class KitabFinder
{
    private KitabFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param KitabFinderRepository $repository The repository
     */
    public function __construct(KitabFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find kitabs.
     *
     * @param array<mixed> $params The parameters
     *
     * @return KitabData[] A list of kitabs
     */
    public function findKitabs(array $params): array
    {
        return $this->repository->findKitabs($params);
    }
}
