<?php

namespace App\Domain\HayatusSahaba\Repository;

use App\Domain\HayatusSahaba\Data\HayatusSahabaData;
use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class HayatusSahabaFinderRepository
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
     * Find Kitabs.
     *
     * @param array<mixed> $params The Kitab
     *
     * @return  array A list of hayatusSahaba book record
     */
    public function findHayatusSahabas(array $params): array
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaData::TABLENAME);
        $query->select(HayatusSahabaData::COLUMNS);
        $filter_column = $params['column'] ?? null;

        if ($filter_column !== null) {
            if (is_array($filter_column)) {
                foreach ($filter_column as $index => $filter) {
                    if (in_array($filter, HayatusSahabaData::COLUMNS) && is_array($params['column_value']) && !empty($params['column_value'][$index])) {
                        $query->andWhere([
                            $filter => $params['column_value'][$index],
                        ]);
                    }
                }
            } elseif (in_array($params['column'], HayatusSahabaData::COLUMNS) && !empty($params['column_value'])) {
                $query->andWhere([
                    $params['column'] => $params['column_value'],
                ]);
            }
        }

        $order = $params['order'] ?? HayatusSahabaData::TABLENAME . '.id';
        $dir = $params['dir'] ?? 'asc';
        $limit = max($params['limit'] ?? 10, 10);
        $offset = max($params['offset'] ?? 0, 0);

        if ($order) {
            $dir === 'desc' ? $query->orderDesc($order) : $query->order($order);
        }

        if ($limit) {
            $query->limit((int)$limit);
        }

        $query->offset((int)$offset);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        return HayatusSahabaData::toList($rows);
    }
}
