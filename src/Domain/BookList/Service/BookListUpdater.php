<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Data\BookListData;
use App\Domain\BookList\Repository\BookListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookListUpdater
{
    private BookListRepository $repository;

    private BookListValidator $bookListValidator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param BookListRepository $repository The repository
     * @param BookListValidator $bookListValidator The validator
     * @param LoggerFactory $loggerFactory The logger factory
     */
    public function __construct(
        BookListRepository $repository,
        BookListValidator $bookListValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->bookListValidator = $bookListValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('bookList_updater.log')
            ->createLogger();
    }

    /**
     * Update bookList.
     *
     * @param int $bookListId The bookList id
     * @param array<mixed> $data The request data
     *
     * @return void
     */
    public function updateBookList(int $bookListId, array $data): void
    {
        // Input validation
        $this->bookListValidator->validateBookListUpdate($bookListId, $data);

        // Map form data to row
        $bookList = new BookListData($data);
        $bookList->id = $bookListId;

        // Insert bookList
        $this->repository->updateBookList($bookList);

        // Logging
        $this->logger->info(sprintf('BookList updated successfully: %s', $bookListId));
    }
}
