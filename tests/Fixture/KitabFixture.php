<?php

namespace App\Test\Fixture;

/**
 * Fixture.
 */
class KitabFixture
{
    /** @var string Table name */
    public $table = 'db_content';

    /**
     * Records.
     *
     * @var array<mixed> Records
     */
    public $records = [
        [
            'id' => 1,
            'content' => 'content the is very intersting not sure what happened',
            'page_no' => '25',
            'kitab_name' => 'Kitab name 1',
            'chapter_name' => 'test name 1',
        ],
        [
            'id' => 2,
            'content' => 'content test test content content test test content content test test content',
            'page_no' => '2',
            'kitab_name' => 'Kitab name for the test case 2',
            'chapter_name' => 'test  the name 2 by the way',
        ],
    ];
}
