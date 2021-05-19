<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Repository\AppInfoRepository;

/**
 * Service.
 */
final class AppInfoDeleter
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
     * Delete appInfo.
     *
     * @param int $appInfoId The appInfo id
     *
     * @return void
     */
    public function deleteAppInfo(int $appInfoId): void
    {
        // Input validation
        // ...

        $this->repository->deleteAppInfoById($appInfoId);
    }
}
