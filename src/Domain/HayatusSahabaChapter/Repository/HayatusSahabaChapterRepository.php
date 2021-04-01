<?php

namespace App\Domain\HayatusSahabaChapter\Repository;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class HayatusSahabaChapterRepository
{
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
     * Insert HayatusSahabaChapter row.
     *
     * @param HayatusSahabaChapterData $hayatusSahabaChapter The HayatusSahabaChapter data
     *
     * @return int The new ID
     */
    public function insertHayatusSahabaChapter(HayatusSahabaChapterData $hayatusSahabaChapter): int
    {
        $row = $this->toRow($hayatusSahabaChapter);

        return (int)$this->queryFactory->newInsert(HayatusSahabaChapterData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get hayatusSahabaChapter by id.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     *
     * @throws DomainException
     *
     * @return HayatusSahabaChapterData The hayatusSahabaChapter
     */
    public function getHayatusSahabaChapterById(int $hayatusSahabaChapterId): HayatusSahabaChapterData
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaChapterData::TABLENAME);
        $query->select(HayatusSahabaChapterData::COLUMNS);

        $query->andWhere(['id' => $hayatusSahabaChapterId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('HayatusSahabaChapter not found: %s', $hayatusSahabaChapterId));
        }

        return new HayatusSahabaChapterData($row);
    }

    /**
     * Get hayatusSahabaChapter by hayatusSahabaChapter_name.
     *
     * @param string $hayatusSahabaChapterName The db_cotent hayatusSahabaChapter_name
     *
     * @throws DomainException
     *
     * @return array The hayatusSahabaChapters find with the chapter name
     */
    public function getHayatusSahabaChapterByName(string $hayatusSahabaChapterName): array
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaChapterData::TABLENAME);
        $query->select(HayatusSahabaChapterData::COLUMNS);

        $query->andWhere(['chapter_name' => $hayatusSahabaChapterName]);

        $row = $query->execute()->fetchAll('assoc');

        if (!$row) {
            throw new DomainException(sprintf('HayatusSahabaChapter not found: %s', $hayatusSahabaChapterName));
        }

        return HayatusSahabaChapterData::toList($row);
    }

    /**
     * Update hayatusSahabaChapter row.
     *
     * @param HayatusSahabaChapterData $hayatusSahabaChapter The hayatusSahabaChapter
     *
     * @return void
     */
    public function updateHayatusSahabaChapter(HayatusSahabaChapterData $hayatusSahabaChapter): void
    {
        $row = $this->toRow($hayatusSahabaChapter);

        $this->queryFactory->newUpdate(HayatusSahabaChapterData::TABLENAME, $row)
            ->andWhere(['id' => $hayatusSahabaChapter->id])
            ->execute();
    }

    /**
     * Check hayatusSahabaChapter id.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     *
     * @return bool True if exists
     */
    public function existsHayatusSahabaChapterId(int $hayatusSahabaChapterId): bool
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaChapterData::TABLENAME);
        $query->select('id')->andWhere(['id' => $hayatusSahabaChapterId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete hayatusSahabaChapter row.
     *
     * @param int $hayatusSahabaChapterId The hayatusSahabaChapter id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteHayatusSahabaChapterById(int $hayatusSahabaChapterId): void
    {
        $statement = $this->queryFactory->newDelete(HayatusSahabaChapterData::TABLENAME)
            ->andWhere(['id' => $hayatusSahabaChapterId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete hayatusSahabaChapter: %s', $hayatusSahabaChapterId));
        }
    }

    /**
     * Convert to array.
     *
     * @param HayatusSahabaChapterData $hayatusSahabaChapter The hayatusSahabaChapter data
     *
     * @return array The array
     */
    private function toRow(HayatusSahabaChapterData $hayatusSahabaChapter): array
    {
        return [
            'id' => $hayatusSahabaChapter->id,
            'book_id' => $hayatusSahabaChapter->book_id,
            'book_name' => $hayatusSahabaChapter->book_name,
            'chapter_id' => $hayatusSahabaChapter->chapter_id,
            'chapter_name' => $hayatusSahabaChapter->chapter_name,
            'chapter_title' => $hayatusSahabaChapter->chapter_title,
            'page_bn' => $hayatusSahabaChapter->page_bn,
            'page_en' => $hayatusSahabaChapter->page_en,
        ];
    }
}
