<?php

namespace App\Domain\ChapterList\Repository;

use App\Domain\ChapterList\Data\ChapterListData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * ChapterList Repository.
 */
final class ChapterListRepository
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
     * Insert ChapterList row.
     *
     * @param ChapterListData $chapterList The ChapterList data
     *
     * @return int The new ID
     */
    public function insertChapterList(ChapterListData $chapterList): int
    {
        $row = $this->toRow($chapterList);

        return (int)$this->queryFactory->newInsert(ChapterListData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get chapterList by id.
     *
     * @param int $chapterListId The chapterList id
     *
     * @throws DomainException
     *
     * @return ChapterListData The chapterList
     */
    public function getChapterListById(int $chapterListId): ChapterListData
    {
        $query = $this->queryFactory->newSelect(ChapterListData::TABLENAME);
        $query->select(ChapterListData::COLUMNS);

        $query->andWhere(['id' => $chapterListId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('ChapterList not found: %s', $chapterListId));
        }

        return new ChapterListData($row);
    }

    /**
     * Update chapterList row.
     *
     * @param ChapterListData $chapterList The chapterList
     *
     * @return void
     */
    public function updateChapterList(ChapterListData $chapterList): void
    {
        $row = $this->toRow($chapterList);

        $this->queryFactory->newUpdate(ChapterListData::TABLENAME, $row)
            ->andWhere(['id' => $chapterList->id])
            ->execute();
    }

    /**
     * Check chapterList id.
     *
     * @param int $chapterListId The chapterList id
     *
     * @return bool True if exists
     */
    public function existsChapterListId(int $chapterListId): bool
    {
        $query = $this->queryFactory->newSelect(ChapterListData::TABLENAME);
        $query->select('id')->andWhere(['id' => $chapterListId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete chapterList row.
     *
     * @param int $chapterListId The chapterList id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteChapterListById(int $chapterListId): void
    {
        $statement = $this->queryFactory->newDelete(ChapterListData::TABLENAME)
            ->andWhere(['id' => $chapterListId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete chapterList: %s', $chapterListId));
        }
    }

    /**
     * Convert to array.
     *
     * @param ChapterListData $chapterList The chapterList data
     *
     * @return array The array
     */
    private function toRow(ChapterListData $chapterList): array
    {
        return [
            'id' => $chapterList->id,
            'volume_id' => $chapterList->volume_id,
            'book_name' => $chapterList->book_name,
            'chapter_id' => $chapterList->chapter_id,
            'chapter_name' => $chapterList->chapter_name,
            'chapter_title' => $chapterList->chapter_title,
            'page_bn' => $chapterList->page_bn,
            'page_en' => $chapterList->page_en,
            'book_id' => $chapterList->book_id,
            'active' => $chapterList->active,
        ];
    }
}