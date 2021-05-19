<?php

namespace App\Domain\ChapterList\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class ChapterListData
{
    public ?int $id = null;

    public ?int $volume_id;

    public ?string $book_name;

    public ?int $chapter_id;

    public ?string $chapter_name;

    public ?string $chapter_title;

    public ?string $page_bn;

    public ?int $page_en;

    public ?int $book_id;

    public ?int $active;

    public const TABLENAME = 'chapter_list';

    public const COLUMNS = [
        'id',
        'volume_id',
        'book_name',
        'chapter_id',
        'chapter_name',
        'chapter_title',
        'page_bn',
        'page_en',
        'book_id',
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
        $this->volume_id = $reader->findInt('volume_id');
        $this->book_name = $reader->findString('book_name');
        $this->chapter_id = $reader->findInt('chapter_id');
        $this->chapter_name = $reader->findString('chapter_name');
        $this->chapter_title = $reader->findString('chapter_title');
        $this->page_bn = $reader->findString('page_bn');
        $this->page_en = $reader->findInt('page_en');
        $this->book_id = $reader->findInt('book_id');
        $this->active = $reader->findInt('active');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return ChapterListData[] The list of chapterLists
     */
    public static function toList(array $items): array
    {
        $chapterLists = [];

        foreach ($items as $data) {
            $chapterLists[] = new ChapterListData($data);
        }

        return $chapterLists;
    }
}
