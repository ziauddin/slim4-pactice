<?php

namespace App\Domain\Jiboni\Repository;

use App\Domain\Jiboni\Data\JiboniData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Jiboni Repository.
 */
final class JiboniRepository
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
     * Insert Jiboni row.
     *
     * @param JiboniData $jiboni The Jiboni data
     *
     * @return int The new ID
     */
    public function insertJiboni(JiboniData $jiboni): int
    {
        $row = $this->toRow($jiboni);

        return (int)$this->queryFactory->newInsert(JiboniData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get jiboni by id.
     *
     * @param int $jiboniId The jiboni id
     *
     * @throws DomainException
     *
     * @return JiboniData The jiboni
     */
    public function getJiboniById(int $jiboniId): JiboniData
    {
        $query = $this->queryFactory->newSelect(JiboniData::TABLENAME);
        $query->select(JiboniData::COLUMNS);

        $query->andWhere(['id' => $jiboniId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Jiboni not found: %s', $jiboniId));
        }

        return new JiboniData($row);
    }

    /**
     * Update jiboni row.
     *
     * @param JiboniData $jiboni The jiboni
     *
     * @return void
     */
    public function updateJiboni(JiboniData $jiboni): void
    {
        $row = $this->toRow($jiboni);

        $this->queryFactory->newUpdate(JiboniData::TABLENAME, $row)
            ->andWhere(['id' => $jiboni->id])
            ->execute();
    }

    /**
     * Check jiboni id.
     *
     * @param int $jiboniId The jiboni id
     *
     * @return bool True if exists
     */
    public function existsJiboniId(int $jiboniId): bool
    {
        $query = $this->queryFactory->newSelect(JiboniData::TABLENAME);
        $query->select('id')->andWhere(['id' => $jiboniId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete jiboni row.
     *
     * @param int $jiboniId The jiboni id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteJiboniById(int $jiboniId): void
    {
        $statement = $this->queryFactory->newDelete(JiboniData::TABLENAME)
            ->andWhere(['id' => $jiboniId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete jiboni: %s', $jiboniId));
        }
    }

    /**
     * Convert to array.
     *
     * @param JiboniData $jiboni The jiboni data
     *
     * @return array The array
     */
    private function toRow(JiboniData $jiboni): array
    {
        return [
            'id' => $jiboni->id,
            'title' => $jiboni->title,
            'desc' => $jiboni->desc
        ];
    }
}