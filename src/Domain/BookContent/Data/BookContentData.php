<?php

namespace App\Domain\BookContent\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class BookContentData
{
    public ?int $id = null;

    public ?int $volume_id;

    public ?int $chapter_id;

    public ?string $chapter_name;

    public ?string $description;

    public ?string $page_no;

    public ?int $data_type;

    public ?int $book_id;

    public const TABLENAME = 'book_content';

    public const COLUMNS = [
        'id',
        'volume_id',
        'chapter_id',
        'chapter_name',
        'description',
        'page_no',
        'data_type',
        'book_id',
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
        $this->chapter_id = $reader->findInt('chapter_id');
        $this->chapter_name = $reader->findString('chapter_name');
        $this->description = $reader->findString('description');
        $this->page_no = $reader->findString('page_no');
        $this->data_type = $reader->findInt('data_type');
        $this->book_id = $reader->findInt('book_id');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return BookContentData[] The list of bookContents
     */
    public static function toList(array $items): array
    {
        $bookContents = [];

        foreach ($items as $data) {
            $bookContents[] = new BookContentData($data);
        }

        return $bookContents;
    }
}
