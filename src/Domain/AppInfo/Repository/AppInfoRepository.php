<?php

namespace App\Domain\AppInfo\Repository;

use App\Domain\AppInfo\Data\AppInfoData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * AppInfo Repository.
 */
final class AppInfoRepository
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
     * Insert AppInfo row.
     *
     * @param AppInfoData $appInfo The AppInfo data
     *
     * @return int The new ID
     */
    public function insertAppInfo(AppInfoData $appInfo): int
    {
        $row = $this->toRow($appInfo);

        return (int)$this->queryFactory->newInsert(AppInfoData::TABLENAME, $row)
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get appInfo by id.
     *
     * @param int $appInfoId The appInfo id
     *
     * @throws DomainException
     *
     * @return AppInfoData The appInfo
     */
    public function getAppInfoById(int $appInfoId): AppInfoData
    {
        $query = $this->queryFactory->newSelect(AppInfoData::TABLENAME);
        $query->select(AppInfoData::COLUMNS);

        $query->andWhere(['id' => $appInfoId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('AppInfo not found: %s', $appInfoId));
        }

        return new AppInfoData($row);
    }

    /**
     * Update appInfo row.
     *
     * @param AppInfoData $appInfo The appInfo
     *
     * @return void
     */
    public function updateAppInfo(AppInfoData $appInfo): void
    {
        $row = $this->toRow($appInfo);

        $this->queryFactory->newUpdate(AppInfoData::TABLENAME, $row)
            ->andWhere(['id' => $appInfo->id])
            ->execute();
    }

    /**
     * Check appInfo id.
     *
     * @param int $appInfoId The appInfo id
     *
     * @return bool True if exists
     */
    public function existsAppInfoId(int $appInfoId): bool
    {
        $query = $this->queryFactory->newSelect(AppInfoData::TABLENAME);
        $query->select('id')->andWhere(['id' => $appInfoId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete appInfo row.
     *
     * @param int $appInfoId The appInfo id
     *
     * @throws DomainException
     *
     * @return void
     */
    public function deleteAppInfoById(int $appInfoId): void
    {
        $statement = $this->queryFactory->newDelete(AppInfoData::TABLENAME)
            ->andWhere(['id' => $appInfoId])
            ->execute();

        if (!$statement->count()) {
            throw new DomainException(sprintf('Cannot delete appInfo: %s', $appInfoId));
        }
    }

    /**
     * Convert to array.
     *
     * @param AppInfoData $appInfo The appInfo data
     *
     * @return array The array
     */
    private function toRow(AppInfoData $appInfo): array
    {
        return [
            'id' => $appInfo->id,
            'package' => $appInfo->package,
            'app_name' => $appInfo->app_name,
            'app_id' => $appInfo->app_id,
            'app_url' => $appInfo->app_url,
            'app_image' => $appInfo->app_image,
            'rank' => $appInfo->rank,
            'version' => $appInfo->version,
            'update' => $appInfo->update,
        ];
    }
}
