<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Data\AppInfoData;
use App\Domain\AppInfo\Repository\AppInfoRepository;
use App\Factory\LoggerFactory;
use App\Factory\UploadFileFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class AppInfoUpdater
{
    private AppInfoRepository $repository;

    private AppInfoValidator $appInfoValidator;

    private UploadFileFactory $fileUploded;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AppInfoRepository $repository The repository
     * @param AppInfoValidator $appInfoValidator The validator
     * @param UploadeFileFactory $fileUploaded The UploadFileFactory
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        AppInfoRepository $repository,
        AppInfoValidator $appInfoValidator,
        UploadFileFactory $fileUploaded,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->appInfoValidator = $appInfoValidator;
        $this->fileUploaded = $fileUploaded;
        $this->logger = $loggerFactory
            ->addFileHandler('appInfo_updater.log')
            ->createLogger();
    }

    /**
     * Update appInfo.
     *
     * @param int $appInfoId The appInfo id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateAppInfo(int $appInfoId, array $data): void
    {
        // Input validation
        $this->appInfoValidator->validateAppInfoUpdate($appInfoId, $data);

        if (isset($data['uploadedFile'])) {
            if ($data['uploadedFile']['app_image']->getError() === UPLOAD_ERR_OK) {
                $filename = $this->fileUploaded->moveUploadedFile($data['uploadedFile']['app_image']);
                $data['app_image'] = $filename;
            }
        }

        // Map form data to row
        $appInfo = new AppInfoData($data);
        $appInfo->id = $appInfoId;

        // Insert appInfo
        $this->repository->updateAppInfo($appInfo);

        // Logging
        $this->logger->info(sprintf('AppInfo updated successfully: %s', $appInfoId));
    }
}
