<?php

namespace App\Domain\Jiboni\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class JiboniData
{
    public ?int $id = null;

    public ?string $title;

    public ?string $desc;

    public const TABLENAME = 'jiboni';

    public const COLUMNS = [
        'id',
        'title',
        'desc'
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
        $this->title = $reader->findString('title');
        $this->desc = $reader->findString('desc');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return JiboniData[] The list of jibonis
     */
    public static function toList(array $items): array
    {
        $jibonis = [];

        foreach ($items as $data) {
            $jibonis[] = new JiboniData($data);
        }

        return $jibonis;
    }
}