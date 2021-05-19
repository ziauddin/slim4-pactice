<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Data\BookListData;
use App\Domain\BookList\Repository\BookListRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Service.
 */
final class BookListCreator
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
            ->addFileHandler('bookList_creator.log')
            ->createLogger();
    }

    /**
     * Create a new bookList.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new bookList ID
     */
    public function createBookList(array $data): int
    {
        // Input validation
        $this->bookListValidator->validateBookList($data);

        // Map form data to bookList DTO (model)
        $bookList = new BookListData($data);

        // Insert bookList and get new bookList ID
        $bookListId = $this->repository->insertBookList($bookList);

        // Logging
        $this->logger->info(sprintf('BookList created successfully: %s', $bookListId));

        return $bookListId;
    }
}
