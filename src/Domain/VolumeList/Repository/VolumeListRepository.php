<?php

namespace App\Domain\VolumeList\Repository;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * VolumeList Repository.
 */
final class VolumeListRepository
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
     * Insert VolumeList row.
     *
     * @param VolumeListData $volumeList The VolumeList data
     *
     * @return int The new ID
     */
    public function insertVolumeList(VolumeListData $volumeList): int
    {
        $row = $this->toRow($volumeList);

        return (int)$this->queryFactory->newInsert(VolumeListData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get volumeList by id.
     *
     * @param int $volumeListId The volumeList id
     *
     * @throws DomainException
     *
     * @return VolumeListData The volumeList
     */
    public function getVolumeListById(int $volumeListId): VolumeListData
    {
        $query = $this->queryFactory->newSelect(VolumeListData::TABLENAME);
        $query->select(VolumeListData::COLUMNS);

        $query->andWhere(['id' => $volumeListId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('VolumeList not found: %s', $volumeListId));
        }

        return new VolumeListData($row);
    }

    /**
     * Update volumeList row.
     *
     * @param VolumeListData $volumeList The volumeList
     *
     * @return void
     */
    public function updateVolumeList(VolumeListData $volumeList): void
    {
        $row = $this->toRow($volumeList);

        $this->queryFactory->newUpdate(VolumeListData::TABLENAME, $row)
            ->andWhere(['id' => $volumeList->id])
            ->execute();
    }

    /**
     * Check volumeList id.
     *
     * @param int $volumeListId The volumeList id
     *
     * @return bool True if exists
     */
    public function existsVolumeListId(int $volumeListId): bool
    {
        $query = $this->queryFactory->newSelect(VolumeListData::TABLENAME);
        $query->select('id')->andWhere(['id' => $volumeListId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete volumeList row.
     *
     * @param int $volumeListId The volumeList id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteVolumeListById(int $volumeListId): void
    {
        $statement = $this->queryFactory->newDelete(VolumeListData::TABLENAME)
            ->andWhere(['id' => $volumeListId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete volumeList: %s', $volumeListId));
        }
    }

    /**
     * Convert to array.
     *
     * @param VolumeListData $volumeList The volumeList data
     *
     * @return array The array
     */
    private function toRow(VolumeListData $volumeList): array
    {
        return [
            'id' => $volumeList->id,
            'book_id' => $volumeList->book_id,
            'volume_id' => $volumeList->volume_id,
            'name' => $volumeList->name,
            'title' => $volumeList->title,
            'has_child' => $volumeList->has_child,
            'chapter_id' => $volumeList->chapter_id,
            'active' => $volumeList->active,
        ];
    }
}
