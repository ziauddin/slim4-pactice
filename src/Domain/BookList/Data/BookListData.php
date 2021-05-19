<?php

namespace App\Domain\BookList\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class BookListData
{
    public ?int $id = null;

    public ?string $book_name;

    public ?string $author_name;

    public ?int $has_volume;

    public ?int $rank_no;

    public ?int $active;

    public const TABLENAME = 'book_list';

    public const COLUMNS = [
        'id',
        'book_name',
        'author_name',
        'has_volume',
        'rank_no',
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
        $this->book_name = $reader->findString('book_name');
        $this->author_name = $reader->findString('author_name');
        $this->has_volume = $reader->findInt('has_volume');
        $this->rank_no = $reader->findInt('rank_no');
        $this->active = $reader->findInt('active');
    }

    /**
     * Convert to array.
     *
     * @param array $items The items
     *
     * @return BookListData[] The list of bookLists
     */
    public static function toList(array $items): array
    {
        $bookLists = [];

        foreach ($items as $data) {
            $bookLists[] = new BookListData($data);
        }

        return $bookLists;
    }
}
