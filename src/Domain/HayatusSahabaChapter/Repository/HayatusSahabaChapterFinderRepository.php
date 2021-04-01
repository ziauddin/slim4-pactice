<?php

namespace App\Domain\HayatusSahabaChapter\Repository;

use App\Domain\HayatusSahabaChapter\Data\HayatusSahabaChapterData;
use App\Factory\QueryFactory;

/**
 * Repository.
 */
final class HayatusSahabaChapterFinderRepository
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
     * Find HayatusSahabaChapters.
     *
     * @param array<mixed> $params The HayatusSahabaChapter
     *
     * @return HayatusSahabaChapterData[] A list of HayatusSahabaChapters
     */
    public function findHayatusSahabaChapters(array $params): array
    {
        $query = $this->queryFactory->newSelect(HayatusSahabaChapterData::TABLENAME);
        $query->select(HayatusSahabaChapterData::COLUMNS);

        $filter_column = $params['column'] ?? null;

        if ($filter_column !== null) {
            if (is_array($filter_column)) {
                foreach ($filter_column as $index => $filter) {
                    if (in_array($filter, HayatusSahabaChapterData::COLUMNS) && is_array($params['column_value']) && !empty($params['column_value'][$index])) {
                        $query->andWhere([
                            $filter => $params['column_value'][$index],
                        ]);
                    }
                }
            } elseif (in_array($params['column'], HayatusSahabaChapterData::COLUMNS) && !empty($params['column_value'])) {
                $query->andWhere([
                    $params['column'] => $params['column_value'],
                ]);
            }
        }

        $order = $params['order'] ?? HayatusSahabaChapterData::TABLENAME . '.id';
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

        return HayatusSahabaChapterData::toList($rows);
    }
}
