<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Data\BookListData;
use App\Domain\BookList\Repository\BookListRepository;

/**
 * Service.
 */
final class BookListReader
{
    private BookListRepository $repository;

    /**
     * The constructor.
     *
     * @param BookListRepository $repository The repository
     */
    public function __construct(BookListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a bookList.
     *
     * @param int $bookListId The bookList id
     *
     * @return BookListData The bookList data
     */
    public function getBookListDataById(int $bookListId): BookListData
    {
        // Input validation
        // ...

        // Fetch data from the database
        $bookList = $this->repository->getBookListById($bookListId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Optional: Map result
        // ...

        return $bookList;
    }
}
