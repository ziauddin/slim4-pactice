<?php

namespace App\Domain\Kitab\Service;

use App\Domain\Kitab\Data\KitabData;
use App\Domain\Kitab\Repository\KitabRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class KitabCreator
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
            ->addFileHandler('kitab_creator.log')
            ->createLogger();
    }

    /**
     * Create a new kitab.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new kitab ID
     */
    public function createKitab(array $data): int
    {
        // Input validation
        $this->kitabValidator->validateKitab($data);

        // Map form data to kitab DTO (model)
        $kitab = new KitabData($data);

        // Insert kitab and get new kitab ID
        $kitabId = $this->repository->insertKitab($kitab);

        // Logging
        $this->logger->info(sprintf('Kitab created successfully: %s', $kitabId));

        return $kitabId;
    }
}
