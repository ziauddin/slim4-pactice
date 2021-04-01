<?php

namespace App\Domain\HayatusSahaba\Service;

use App\Domain\HayatusSahaba\Data\HayatusSahabaData;
use App\Domain\HayatusSahaba\Repository\HayatusSahabaRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class HayatusSahabaUpdater
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
            ->addFileHandler('hayatusSahaba_updater.log')
            ->createLogger();
    }

    /**
     * Update hayatusSahaba.
     *
     * @param int $hayatusSahabaId The hayatusSahaba id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateHayatusSahaba(int $hayatusSahabaId, array $data): void
    {
        // Input validation
        $this->hayatusSahabaValidator->validateHayatusSahabaUpdate($hayatusSahabaId, $data);

        // Map form data to row
        $hayatusSahaba = new HayatusSahabaData($data);
        $hayatusSahaba->id = $hayatusSahabaId;

        // Insert hayatusSahaba
        $this->repository->updateHayatusSahaba($hayatusSahaba);

        // Logging
        $this->logger->info(sprintf('HayatusSahaba updated successfully: %s', $hayatusSahabaId));
    }
}
