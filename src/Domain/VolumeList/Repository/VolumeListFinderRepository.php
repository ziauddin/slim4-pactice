<?php

namespace App\Domain\VolumeList\Repository;

use App\Domain\VolumeList\Data\VolumeListData;
use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class VolumeListFinderRepository
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
     * Find VolumeLists.
     *
     * @param array<mixed> $params The ookList
     *
     * @return VolumeListData[] A list of VolumeLists
     */
    public function findVolumeLists(array $params): array
    {
        $query = $this->queryFactory->newSelect(VolumeListData::TABLENAME);
        $query->select(VolumeListData::COLUMNS);

        $order = $params['order'] ?? VolumeListData::TABLENAME . '.id';
        $dir = $params['dir'] ?? 'asc';
        $limit = max($params['limit'] ?? 10, 10);
        $offset = max($params['offset'] ?? 0, 0);
        $filter_column = $params['column'] ?? null;

        if ($filter_column !== null) {
            if (is_array($filter_column)) {
                foreach ($filter_column as $index => $filter) {
                    if (in_array($filter, VolumeListData::COLUMNS) && is_array($params['column_value']) && !empty($params['column_value'][$index])) {
                        $query->andWhere([
                            $filter => $params['column_value'][$index],
                        ]);
                    }
                }
            } elseif (in_array($params['column'], VolumeListData::COLUMNS) && !empty($params['column_value'])) {
                $query->andWhere([
                    $params['column'] => $params['column_value'],
                ]);
            }
        }

        if ($order) {
            $dir === 'desc' ? $query->orderDesc($order) : $query->order($order);
        }

        if ($limit) {
            $query->limit((int)$limit);
        }

        $query->offset((int)$offset);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return VolumeListData::toList($rows);
    }
}
