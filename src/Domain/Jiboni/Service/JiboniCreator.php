<?php

namespace App\Domain\Jiboni\Service;

use App\Domain\Jiboni\Data\JiboniData;
use App\Domain\Jiboni\Repository\JiboniRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class JiboniCreator
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
            ->addFileHandler('jiboni_creator.log')
            ->createLogger();
    }

    /**
     * Create a new jiboni.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new jiboni ID
     */
    public function createJiboni(array $data): int
    {
        // Input validation
        $this->jiboniValidator->validateJiboni($data);

        // Map form data to jiboni DTO (model)
        $jiboni = new JiboniData($data);

        // Insert jiboni and get new jiboni ID
        $jiboniId = $this->repository->insertJiboni($jiboni);

        // Logging
        $this->logger->info(sprintf('Jiboni created successfully: %s', $jiboniId));

        return $jiboniId;
    }
}