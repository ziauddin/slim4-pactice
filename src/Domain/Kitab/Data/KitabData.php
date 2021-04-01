<?php

namespace App\Domain\Kitab\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class KitabData
{
    public ?int $id = null;

    public ?string $content;

    public ?string $page_no;

    public ?string $kitab_name;

    public ?string $chapter_name;

    public const TABLENAME = 'db_content';

    public const COLUMNS = [
        'id',
        'content',
        'page_no',
        'kitab_name',
        'chapter_name',
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
        $this->content = $reader->findString('content');
        $this->page_no = $reader->findString('page_no');
        $this->kitab_name = $reader->findString('kitab_name');
        $this->chapter_name = $reader->findString('chapter_name');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return KitabData[] The list of kitabs
     */
    public static function toList(array $items): array
    {
        $kitabs = [];

        foreach ($items as $data) {
            $kitabs[] = new KitabData($data);
        }

        return $kitabs;
    }
}
