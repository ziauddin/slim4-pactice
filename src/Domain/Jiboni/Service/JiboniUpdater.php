<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Data\JiboniData;
use App\Domain\Jiboni\Repository\JiboniRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class JiboniUpdater
{
    private JiboniRepository $repository;

    private JiboniValidator $jiboniValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param JiboniRepository $repository The repository
     * @param JiboniValidator $jiboniValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        JiboniRepository $repository,
        JiboniValidator $jiboniValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->jiboniValidator = $jiboniValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('jiboni_updater.log')
            ->createLogger();
    }

    /**
     * Update jiboni.
     *
     * @param int $jiboniId The jiboni id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateJiboni(int $jiboniId, array $data): void
    {
        // Input validation
        $this->jiboniValidator->validateJiboniUpdate($jiboniId, $data);

        // Map form data to row
        $jiboni = new JiboniData($data);
        $jiboni->id = $jiboniId;

        // Insert jiboni
        $this->repository->updateJiboni($jiboni);

        // Logging
        $this->logger->info(sprintf('Jiboni updated successfully: %s', $jiboniId));
    }
}
