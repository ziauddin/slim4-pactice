<?php

namespace App\Domain\VolumeList\Service;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Domain\VolumeList\Repository\VolumeListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class VolumeListCreator
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
            ->addFileHandler('volumeList_creator.log')
            ->createLogger();
    }

    /**
     * Create a new volumeList.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new volumeList ID
     */
    public function createVolumeList(array $data): int
    {
        // Input validation
        $this->volumeListValidator->validateVolumeList($data);

        // Map form data to volumeList DTO (model)
        $volumeList = new VolumeListData($data);

        // Insert volumeList and get new volumeList ID
        $volumeListId = $this->repository->insertVolumeList($volumeList);

        // Logging
        $this->logger->info(sprintf('VolumeList created successfully: %s', $volumeListId));

        return $volumeListId;
    }
}
