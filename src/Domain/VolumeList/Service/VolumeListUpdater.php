<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Domain\VolumeList\Repository\VolumeListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class VolumeListUpdater
{
    private VolumeListRepository $repository;

    private VolumeListValidator $volumeListValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param VolumeListRepository $repository The repository
     * @param VolumeListValidator $volumeListValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        VolumeListRepository $repository,
        VolumeListValidator $volumeListValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->volumeListValidator = $volumeListValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('volumeList_updater.log')
            ->createLogger();
    }

    /**
     * Update volumeList.
     *
     * @param int $volumeListId The volumeList id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateVolumeList(int $volumeListId, array $data): void
    {
        // Input validation
        $this->volumeListValidator->validateVolumeListUpdate($volumeListId, $data);

        // Map form data to row
        $volumeList = new VolumeListData($data);
        $volumeList->id = $volumeListId;

        // Insert volumeList
        $this->repository->updateVolumeList($volumeList);

        // Logging
        $this->logger->info(sprintf('VolumeList updated successfully: %s', $volumeListId));
    }
}
