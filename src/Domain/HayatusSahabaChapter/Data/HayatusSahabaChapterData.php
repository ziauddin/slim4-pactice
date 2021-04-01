<?php

namespace App\Domain\HayatusSahabaChapter\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class HayatusSahabaChapterData
{
    public ?int $id = null;

    public ?int $book_id;

    public ?string $book_name;

    public ?int $chapter_id;

    public ?string $chapter_name;

    public ?string $chapter_title;

    public ?string $page_bn;

    public ?int $page_en;

    public const TABLENAME = 'hayatus_sahaba_chapter_list';

    public const COLUMNS = [
        'id',
        'book_id',
        'book_name',
        'chapter_id',
        'chapter_name',
        'chapter_title',
        'page_bn',
        'page_en',
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
        $this->book_name = $reader->findString('book_name');
        $this->chapter_id = $reader->findInt('chapter_id');
        $this->chapter_name = $reader->findString('chapter_name');
        $this->chapter_title = $reader->findString('chapter_title');
        $this->page_bn = $reader->findString('page_bn');
        $this->page_en = $reader->findInt('page_en');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return HayatusSahabaChapterData[] The list of hayatusSahabaChapters
     */
    public static function toList(array $items): array
    {
        $hayatusSahabaChapters = [];

        foreach ($items as $data) {
            $hayatusSahabaChapters[] = new HayatusSahabaChapterData($data);
        }

        return $hayatusSahabaChapters;
    }
}
