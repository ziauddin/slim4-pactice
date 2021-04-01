<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Data\HayatusSahabaData;
use App\Domain\HayatusSahaba\Repository\HayatusSahabaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class HayatusSahabaCreator
{
    private HayatusSahabaRepository $repository;

    private HayatusSahabaValidator $hayatusSahabaValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param HayatusSahabaRepository $repository The repository
     * @param HayatusSahabaValidator $hayatusSahabaValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        HayatusSahabaRepository $repository,
        HayatusSahabaValidator $hayatusSahabaValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->hayatusSahabaValidator = $hayatusSahabaValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('hayatusSahaba_creator.log')
            ->createLogger();
    }

    /**
     * Create a new hayatusSahaba.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new hayatusSahaba ID
     */
    public function createHayatusSahaba(array $data): int
    {
        // Input validation
        $this->hayatusSahabaValidator->validateHayatusSahaba($data);

        // Map form data to hayatusSahaba DTO (model)
        $hayatusSahaba = new HayatusSahabaData($data);

        // Insert hayatusSahaba and get new hayatusSahaba ID
        $hayatusSahabaId = $this->repository->insertHayatusSahaba($hayatusSahaba);

        // Logging
        $this->logger->info(sprintf('HayatusSahaba created successfully: %s', $hayatusSahabaId));

        return $hayatusSahabaId;
    }
}
