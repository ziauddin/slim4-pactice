<?php

namespace App\Domain\BookContent\Repository;

use App\Domain\BookContent\Data\BookContentData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * BookContent Repository.
 */
final class BookContentRepository
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
     * Insert BookContent row.
     *
     * @param BookContentData $bookContent The BookContent data
     *
     * @return int The new ID
     */
    public function insertBookContent(BookContentData $bookContent): int
    {
        $row = $this->toRow($bookContent);

        return (int)$this->queryFactory->newInsert(BookContentData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get bookContent by id.
     *
     * @param int $bookContentId The bookContent id
     *
     * @throws DomainException
     *
     * @return BookContentData The bookContent
     */
    public function getBookContentById(int $bookContentId): BookContentData
    {
        $query = $this->queryFactory->newSelect(BookContentData::TABLENAME);
        $query->select(BookContentData::COLUMNS);

        $query->andWhere(['id' => $bookContentId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('BookContent not found: %s', $bookContentId));
        }

        return new BookContentData($row);
    }

    /**
     * Update bookContent row.
     *
     * @param BookContentData $bookContent The bookContent
     *
     * @return void
     */
    public function updateBookContent(BookContentData $bookContent): void
    {
        $row = $this->toRow($bookContent);

        $this->queryFactory->newUpdate(BookContentData::TABLENAME, $row)
            ->andWhere(['id' => $bookContent->id])
            ->execute();
    }

    /**
     * Check bookContent id.
     *
     * @param int $bookContentId The bookContent id
     *
     * @return bool True if exists
     */
    public function existsBookContentId(int $bookContentId): bool
    {
        $query = $this->queryFactory->newSelect(BookContentData::TABLENAME);
        $query->select('id')->andWhere(['id' => $bookContentId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete bookContent row.
     *
     * @param int $bookContentId The bookContent id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteBookContentById(int $bookContentId): void
    {
        $statement = $this->queryFactory->newDelete(BookContentData::TABLENAME)
            ->andWhere(['id' => $bookContentId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete bookContent: %s', $bookContentId));
        }
    }

    /**
     * Convert to array.
     *
     * @param BookContentData $bookContent The bookContent data
     *
     * @return array The array
     */
    private function toRow(BookContentData $bookContent): array
    {
        return [
            'id' => $bookContent->id,
            'volume_id' => $bookContent->volume_id,
            'chapter_id' => $bookContent->chapter_id,
            'chapter_name' => $bookContent->chapter_name,
            'description' => $bookContent->description,
            'page_no' => $bookContent->page_no,
            'data_type' => $bookContent->data_type,
            'book_id' => $bookContent->book_id,
        ];
    }
}
