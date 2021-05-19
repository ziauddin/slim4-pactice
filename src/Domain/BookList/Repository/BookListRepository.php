<?php

namespace App\Domain\BookList\Repository;

use App\Domain\BookList\Data\BookListData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * BookList Repository.
 */
final class BookListRepository
{
    /**
     * @var QueryFactory The sql abastraction class instance for query operarion
     */
    private QueryFactory $queryFactory;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Insert BookList row.
     *
     * @param BookListData $bookList The BookList data
     *
     * @return int The new ID
     */
    public function insertBookList(BookListData $bookList): int
    {
        $row = $this->toRow($bookList);

        return (int)$this->queryFactory->newInsert(BookListData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get bookList by id.
     *
     * @param int $bookListId The bookList id
     *
     * @throws DomainException
     *
     * @return BookListData The bookList
     */
    public function getBookListById(int $bookListId): BookListData
    {
        $query = $this->queryFactory->newSelect(BookListData::TABLENAME);
        $query->select(BookListData::COLUMNS);

        $query->andWhere(['id' => $bookListId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('BookList not found: %s', $bookListId));
        }

        return new BookListData($row);
    }

    /**
     * Update bookList row.
     *
     * @param BookListData $bookList The bookList
     *
     * @return void
     */
    public function updateBookList(BookListData $bookList): void
    {
        $row = $this->toRow($bookList);

        $this->queryFactory->newUpdate(BookListData::TABLENAME, $row)
            ->andWhere(['id' => $bookList->id])
            ->execute();
    }

    /**
     * Check bookList id.
     *
     * @param int $bookListId The bookList id
     *
     * @return bool True if exists
     */
    public function existsBookListId(int $bookListId): bool
    {
        $query = $this->queryFactory->newSelect(BookListData::TABLENAME);
        $query->select('id')->andWhere(['id' => $bookListId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete bookList row.
     *
     * @param int $bookListId The bookList id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteBookListById(int $bookListId): void
    {
        $statement = $this->queryFactory->newDelete(BookListData::TABLENAME)
            ->andWhere(['id' => $bookListId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete bookList: %s', $bookListId));
        }
    }

    /**
     * Convert to array.
     *
     * @param BookListData $bookList The bookList data
     *
     * @return array The array
     */
    private function toRow(BookListData $bookList): array
    {
        return [
            'id' => $bookList->id,
            'book_name' => $bookList->book_name,
            'author_name' => $bookList->author_name,
            'has_volume' => $bookList->has_volume,
            'rank_no' => $bookList->rank_no,
            'active' => $bookList->active,
        ];
    }
}
