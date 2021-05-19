<?php

namespace App\Domain\AppInfo\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class AppInfoData
{
    public ?int $id = null;

    public ?string $package;

    public ?string $app_name;

    public ?string $app_id;

    public ?string $app_url;

    public ?string $app_image;

    public ?int $rank;

    public ?int $version;

    public ?int $update;

    public const TABLENAME = 'app_info';

    public const COLUMNS = [
        'id',
        'package',
        'app_name',
        'app_id',
        'app_url',
        'app_image',
        'rank',
        'version',
        'update',
    ];

    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->id = $reader->findInt('id');
        $this->package = $reader->findString('package');
        $this->app_name = $reader->findString('app_name');
        $this->app_id = $reader->findString('app_id');
        $this->app_url = $reader->findString('app_url');
        $this->app_image = $reader->findString('app_image');
        $this->rank = $reader->findInt('rank');
        $this->version = $reader->findInt('version');
        $this->update = $reader->findInt('update');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return AppInfoData[] The list of appInfos
     */
    public static function toList(array $items): array
    {
        $appInfos = [];

        foreach ($items as $data) {
            $appInfos[] = new AppInfoData($data);
        }

        return $appInfos;
    }
}
