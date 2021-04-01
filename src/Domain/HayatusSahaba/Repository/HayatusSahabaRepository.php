<?php

namespace App\Domain\HayatusSahaba\Repository;

use App\Domain\HayatusSahaba\Data\HayatusSahabaData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class HayatusSahabaRepository
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
     * Insert HayatusSahaba row.
     *
     * @param HayatusSahabaData $hayatusSahaba The HayatusSahaba data
     *
     * @return int The new ID
     */
    public function insertHayatusSahaba(HayatusSahabaData $hayatusSahaba): int
    {
        $row = $this->toRow($hayatusSahaba);

        return (int)$this->queryFactory->newInsert(HayatusSahabaData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get hayatusSahaba by id.
     *
     * @param int $hayatusSahabaId The hayatusSahaba id
     *
     * @throws DomainException
     *
     * @return HayatusSahabaData The hayatusSahabaData
     */
    public function getHayatusSahabaById(int $hayatusSahabaId): HayatusSahabaData
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaData::TABLENAME);
        $query->select(HayatusSahabaData::COLUMNS);

        $query->andWhere(['id' => $hayatusSahabaId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Hayatus Sahaba not found: %s', $hayatusSahabaId));
        }

        return new HayatusSahabaData($row);
    }

    /**
     * Update hayatusSahaba row.
     *
     * @param HayatusSahabaData $hayatusSahaba The hayatusSahaba
     *
     * @return void
     */
    public function updateHayatusSahaba(HayatusSahabaData $hayatusSahaba): void
    {
        $row = $this->toRow($hayatusSahaba);

        $this->queryFactory->newUpdate(HayatusSahabaData::TABLENAME, $row)
            ->andWhere(['id' => $hayatusSahaba->id])
            ->execute();
    }

    /**
     * Check hayatusSahaba id.
     *
     * @param int $hayatusSahabaId The hayatusSahaba id
     *
     * @return bool True if exists
     */
    public function existsHayatusSahabaId(int $hayatusSahabaId): bool
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaData::TABLENAME);
        $query->select('id')->andWhere(['id' => $hayatusSahabaId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete hayatusSahaba row.
     *
     * @param int $hayatusSahabaId The hayatusSahaba id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteHayatusSahabaById(int $hayatusSahabaId): void
    {
        $statement = $this->queryFactory->newDelete(HayatusSahabaData::TABLENAME)
            ->andWhere(['id' => $hayatusSahabaId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete hayatusSahaba: %s', $hayatusSahabaId));
        }
    }

    /**
     * Convert to array.
     *
     * @param HayatusSahabaData $hayatusSahaba The hayatusSahaba data
     *
     * @return array The array
     */
    private function toRow(HayatusSahabaData $hayatusSahaba): array
    {
        return [
            'id' => $hayatusSahaba->id,
            'book_id' => $hayatusSahaba->book_id,
            'chapter_id' => $hayatusSahaba->chapter_id,
            'chapter_name' => $hayatusSahaba->chapter_name,
            'description' => $hayatusSahaba->description,
            'page_no' => $hayatusSahaba->page_no,
        ];
    }
}
