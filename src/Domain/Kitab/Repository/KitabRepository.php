<?php

namespace App\Domain\Kitab\Repository;

use App\Domain\Kitab\Data\KitabData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Kitab Repository.
 */
final class KitabRepository
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
     * Insert Kitab row.
     *
     * @param KitabData $kitab The Kitab data
     *
     * @return int The new ID
     */
    public function insertKitab(KitabData $kitab): int
    {
        $row = $this->toRow($kitab);

        return (int)$this->queryFactory->newInsert(KitabData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get kitab by id.
     *
     * @param int $kitabId The kitab id
     *
     * @throws DomainException
     *
     * @return KitabData The kitab
     */
    public function getKitabById(int $kitabId): KitabData
    {
        $query = $this->queryFactory->newSelect(KitabData::TABLENAME);
        $query->select(KitabData::COLUMNS);

        $query->andWhere(['id' => $kitabId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Kitab not found: %s', $kitabId));
        }

        return new KitabData($row);
    }

    /**
     * Update kitab row.
     *
     * @param KitabData $kitab The kitab
     *
     * @return void
     */
    public function updateKitab(KitabData $kitab): void
    {
        $row = $this->toRow($kitab);

        $this->queryFactory->newUpdate(KitabData::TABLENAME, $row)
            ->andWhere(['id' => $kitab->id])
            ->execute();
    }

    /**
     * Check kitab id.
     *
     * @param int $kitabId The kitab id
     *
     * @return bool True if exists
     */
    public function existsKitabId(int $kitabId): bool
    {
        $query = $this->queryFactory->newSelect(KitabData::TABLENAME);
        $query->select('id')->andWhere(['id' => $kitabId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete kitab row.
     *
     * @param int $kitabId The kitab id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteKitabById(int $kitabId): void
    {
        $statement = $this->queryFactory->newDelete(KitabData::TABLENAME)
            ->andWhere(['id' => $kitabId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete kitab: %s', $kitabId));
        }
    }

    /**
     * Convert to array.
     *
     * @param KitabData $kitab The kitab data
     *
     * @return array The array
     */
    private function toRow(KitabData $kitab): array
    {
        return [
            'id' => $kitab->id,
            'content' => $kitab->content,
            'page_no' => $kitab->page_no,
            'kitab_name' => $kitab->kitab_name,
            'chapter_name' => $kitab->chapter_name,
        ];
    }
}
