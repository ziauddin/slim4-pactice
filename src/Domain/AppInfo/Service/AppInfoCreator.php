<?php

namespace App\Domain\AppInfo\Service;

use App\Domain\AppInfo\Data\AppInfoData;
use App\Domain\AppInfo\Repository\AppInfoRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Factory\UploadFileFactory;

/**
 * Service.
 */
final class AppInfoCreator
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
        LoggerFactory $loggerFactory,
        UploadFileFactory $fileUploaded
    ) {
        $this->repository = $repository;
        $this->appInfoValidator = $appInfoValidator;
        $this->fileUploaded = $fileUploaded;
        $this->logger = $loggerFactory
            ->addFileHandler('appInfo_creator.log')
            ->createLogger();
    }

    /**
     * Create a new appInfo.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new appInfo ID
     */
    public function createAppInfo(array $data): int
    {
        // Input validation
        $this->appInfoValidator->validateAppInfo($data);

        if (isset($data['uploadedFile'])) {
            if ($data['uploadedFile']['app_image']->getError() === UPLOAD_ERR_OK) {
                $filename = $this->fileUploaded->moveUploadedFile($data['uploadedFile']['app_image']);
                $data['app_image'] = $filename;
            }
        }

        // Map form data to appInfo DTO (model)
        $appInfo = new AppInfoData($data);

        // Insert appInfo and get new appInfo ID
        $appInfoId = $this->repository->insertAppInfo($appInfo);

        // Logging
        $this->logger->info(sprintf('AppInfo created successfully: %s', $appInfoId));

        return $appInfoId;
    }
}