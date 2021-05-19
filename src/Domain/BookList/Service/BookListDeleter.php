<?php

namespace App\Domain\BookList\Service;

use App\Domain\BookList\Repository\BookListRepository;

/**
 * Service.
 */
final class BookListDeleter
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
     * Delete bookList.
     *
     * @param int $bookListId The bookList id
     *
     * @return void
     */
    public function deleteBookList(int $bookListId): void
    {
        // Input validation
        // ...

        $this->repository->deleteBookListById($bookListId);
    }
}
