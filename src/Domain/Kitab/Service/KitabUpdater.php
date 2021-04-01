<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Data\KitabData;
use App\Domain\Kitab\Repository\KitabRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class KitabUpdater
{
    private KitabRepository $repository;

    private KitabValidator $kitabValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param KitabRepository $repository The repository
     * @param KitabValidator $kitabValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        KitabRepository $repository,
        KitabValidator $kitabValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->kitabValidator = $kitabValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('kitab_updater.log')
            ->createLogger();
    }

    /**
     * Update kitab.
     *
     * @param int $kitabId The kitab id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateKitab(int $kitabId, array $data): void
    {
        // Input validation
        $this->kitabValidator->validateKitabUpdate($kitabId, $data);

        // Map form data to row
        $kitab = new KitabData($data);
        $kitab->id = $kitabId;

        // Insert kitab
        $this->repository->updateKitab($kitab);

        // Logging
        $this->logger->info(sprintf('Kitab updated successfully: %s', $kitabId));
    }
}
