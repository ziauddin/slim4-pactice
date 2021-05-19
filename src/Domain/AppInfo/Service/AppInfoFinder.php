<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Data\AppInfoData;
use App\Domain\AppInfo\Repository\AppInfoFinderRepository;

/**
 * Service.
 */
final class AppInfoFinder
{
    private AppInfoFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param AppInfoFinderRepository $repository The repository
     */
    public function __construct(AppInfoFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find appInfos.
     *
     * @param array<mixed> $params The parameters
     *
     * @return AppInfoData[] A list of appInfos
     */
    public function findAppInfos(array $params): array
    {
        return $this->repository->findAppInfos($params);
    }
}
