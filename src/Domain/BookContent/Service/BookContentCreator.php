<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Data\BookContentData;
use App\Domain\BookContent\Repository\BookContentRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookContentCreator
{
    private BookContentRepository $repository;

    private BookContentValidator $bookContentValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param BookContentRepository $repository The repository
     * @param BookContentValidator $bookContentValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        BookContentRepository $repository,
        BookContentValidator $bookContentValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->bookContentValidator = $bookContentValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('bookContent_creator.log')
            ->createLogger();
    }

    /**
     * Create a new bookContent.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new bookContent ID
     */
    public function createBookContent(array $data): int
    {
        // Input validation
        $this->bookContentValidator->validateBookContent($data);

        // Map form data to bookContent DTO (model)
        $bookContent = new BookContentData($data);

        // Insert bookContent and get new bookContent ID
        $bookContentId = $this->repository->insertBookContent($bookContent);

        // Logging
        $this->logger->info(sprintf('BookContent created successfully: %s', $bookContentId));

        return $bookContentId;
    }
}
