<?php

namespace App\Domain\BookContent\Service;

use App\Domain\BookContent\Data\BookContentData;
use App\Domain\BookContent\Repository\BookContentRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookContentUpdater
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
            ->addFileHandler('bookContent_updater.log')
            ->createLogger();
    }

    /**
     * Update bookContent.
     *
     * @param int $bookContentId The bookContent id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateBookContent(int $bookContentId, array $data): void
    {
        // Input validation
        $this->bookContentValidator->validateBookContentUpdate($bookContentId, $data);

        // Map form data to row
        $bookContent = new BookContentData($data);
        $bookContent->id = $bookContentId;

        // Insert bookContent
        $this->repository->updateBookContent($bookContent);

        // Logging
        $this->logger->info(sprintf('BookContent updated successfully: %s', $bookContentId));
    }
}
