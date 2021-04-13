<?php

namespace App\Domain\Jiboni\Repository;

use App\Domain\Jiboni\Data\JiboniData;
use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class JiboniFinderRepository
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
     * Find Jibonis.
     *
     * @param array<mixed> $params The Jiboni
     *
     * @return JiboniData[] A list of Jibonis
     */
    public function findJibonis(array $params): array
    {
        $query = $this->queryFactory->newSelect(JiboniData::TABLENAME);
        $query->select(JiboniData::COLUMNS);

        $order = $params['order'] ?? JiboniData::TABLENAME . '.id';
        $dir = $params['dir'] ?? 'asc';
        $limit = max($params['limit'] ?? 10, 10);
        $offset = max($params['offset'] ?? 0, 0);
        $filter_column = $params['column'] ?? null;

        if ($filter_column !== null) {
            if (is_array($filter_column)) {
                foreach ($filter_column as $index => $filter) {
                    if (in_array($filter, JiboniData::COLUMNS) && is_array($params['column_value']) && !empty($params['column_value'][$index])) {
                        $query->andWhere([
                            $filter => $params['column_value'][$index],
                        ]);
                    }
                }
            } elseif (in_array($params['column'], JiboniData::COLUMNS) && !empty($params['column_value'])) {
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

        return JiboniData::toList($rows);
    }
}
