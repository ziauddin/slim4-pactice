<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Data\AppInfoData;
use App\Domain\AppInfo\Repository\AppInfoRepository;

/**
 * Service.
 */
final class AppInfoReader
{
    private AppInfoRepository $repository;

    /**
     * The constructor.
     *
     * @param AppInfoRepository $repository The repository
     */
    public function __construct(AppInfoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a appInfo.
     *
     * @param int $appInfoId The appInfo id
     *
     * @return AppInfoData The appInfo data
     */
    public function getAppInfoDataById(int $appInfoId): AppInfoData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $appInfo = $this->repository->getAppInfoById($appInfoId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $appInfo;
    }
}
