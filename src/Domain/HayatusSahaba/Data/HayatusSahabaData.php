<?php

namespace App\Domain\HayatusSahaba\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class HayatusSahabaData
{
    public ?int $id = null;

    public ?int $book_id;

    public ?int $chapter_id;

    public ?string $chapter_name;

    public ?string $description;

    public ?string $page_no;

    public const TABLENAME = 'hayatus_sahaba';

    public const COLUMNS = [
        'id',
        'book_id',
        'chapter_id',
        'chapter_name',
        'description',
        'page_no',
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
        $this->chapter_id = $reader->findInt('chapter_id');
        $this->chapter_name = $reader->findString('chapter_name');
        $this->description = $reader->findString('description');
        $this->page_no = $reader->findString('page_no');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return HayatusSahabaData[] The list of kitabs
     */
    public static function toList(array $items): array
    {
        $HayatusSahabaData = [];

        foreach ($items as $data) {
            $HayatusSahabaData[] = new HayatusSahabaData($data);
        }

        return (array)$HayatusSahabaData;
    }
}
