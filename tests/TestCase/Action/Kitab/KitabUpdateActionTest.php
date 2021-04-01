<?php

namespace App\Test\TestCase\Action\Kitab;

use App\Test\Fixture\KitabFixture;
use App\Test\Traits\AppTestTrait;
use Cake\Chronos\Chronos;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Kitab\KitabUpdateAction
 */
class KitabUpdateActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testUpdateKitab(): void
    {
        //Chronos::setTestNow('2021-02-01 00:00:00');

        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/v1/kitabs/1',
            [
                'content' => 'content the is very intersting not sure what happened',
                'page_no' => '25',
                'kitab_name' => 'Kitab name 2',
                'chapter_name' => 'test name 2',
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);

        // Check database
        $expected = [
            'id' => '1',
            'content' => 'content the is very intersting not sure what happened',
            'page_no' => '25',
            'kitab_name' => 'Kitab name 2',
            'chapter_name' => 'test name 2',
        ];

        $this->assertTableRow($expected, 'db_content', 1, array_keys($expected));
        $this->assertTableRowValue('1', 'db_content', 1, 'id');
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateKitabValidation(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createJsonRequest(
            'PUT',
            '/api/v1/kitabs/1',
            [
                'content' => '',
                'page_no' => '',
                'kitab_name' => '',
                'chapter_name' => '',
            ]
        );
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'error' => [
                    'message' => 'Please check your input',
                    'code' => 422,
                    'details' => [
                        0 => [
                            'message' => 'Input required',
                            'field' => 'content',
                        ],
                        1 => [
                            'message' => 'Input required',
                            'field' => 'page_no',
                        ],
                        2 => [
                            'message' => 'Input required',
                            'field' => 'kitab_name',
                        ],
                        3 => [
                            'message' => 'Input required',
                            'field' => 'chapter_name',
                        ],
                    ],
                ],
            ],
            $response
        );
    }
}
