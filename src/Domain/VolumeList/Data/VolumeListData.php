<?php

namespace App\Domain\VolumeList\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class VolumeListData
{
    public ?int $id = null;

    public ?int $book_id;

    public ?int $volume_id;

    public ?string $name;

    public ?string $title;

    public ?int $has_child;

    public ?int $chapter_id;

    public ?int $active;

    public const TABLENAME = 'volume_list';

    public const COLUMNS = [
        'id',
        'book_id',
        'volume_id',
        'name',
        'title',
        'has_child',
        'chapter_id',
        'active',
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
        $this->book_id = $reader->findInt('book_id');
        $this->volume_id = $reader->findInt('volume_id');
        $this->name = $reader->findString('name');
        $this->title = $reader->findString('title');
        $this->has_child = $reader->findInt('has_child');
        $this->chapter_id = $reader->findInt('chapter_id');
        $this->active = $reader->findInt('active');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return VolumeListData[] The list of volumeLists
     */
    public static function toList(array $items): array
    {
        $volumeLists = [];

        foreach ($items as $data) {
            $volumeLists[] = new VolumeListData($data);
        }

        return $volumeLists;
    }
}
