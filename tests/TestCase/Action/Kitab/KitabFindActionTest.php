<?php

namespace App\Test\TestCase\Action\Kitab;

use App\Test\Fixture\KitabFixture;
use App\Test\Traits\AppTestTrait;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\TestCase;
use Selective\TestTrait\Traits\DatabaseTestTrait;

/**
 * Test.
 *
 * @coversDefaultClass \App\Action\Kitab\KitabFindAction
 */
class KitabFindActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testListKitabs(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createRequest('GET', '/api/v1/kitabs');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonData(
            [
                'kitabs' => [
                    0 => [
                        'id' => 1,
                        'content' => 'content the is very intersting not sure what happened',
                        'page_no' => '25',
                        'kitab_name' => 'Kitab name 1',
                        'chapter_name' => 'test name 1',
                    ],
                    1 => [
                        'id' => 2,
                        'content' => 'content test test content content test test content content test test content',
                        'page_no' => '2',
                        'kitab_name' => 'Kitab name for the test case 2',
                        'chapter_name' => 'test  the name 2 by the way',
                    ],
                ],
            ],
            $response
        );
    }

    /**
     * Test kitab data filter by column name.
     *
     * @return void
     */
    public function testKitabListFilterByColumn(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createRequest('GET', '/api/v1/kitabs?order=page_no&column=page_no&column_value=25');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonData(
            [
                'kitabs' => [
                    0 => [
                        'id' => 1,
                        'content' => 'content the is very intersting not sure what happened',
                        'page_no' => '25',
                        'kitab_name' => 'Kitab name 1',
                        'chapter_name' => 'test name 1',
                    ],
                ],
            ],
            $response
        );
    }

    /**
     * Test kitab data filter by multiple columns.
     *
     * @return void
     */
    public function testKitabListFilterByColumns(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createRequest('GET', '/api/v1/kitabs?order=page_no&column[]=page_no&column[]=kitab_name&column_value[]=25&column_value[]=Kitab name 1');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonData(
            [
                'kitabs' => [
                    0 => [
                        'id' => 1,
                        'content' => 'content the is very intersting not sure what happened',
                        'page_no' => '25',
                        'kitab_name' => 'Kitab name 1',
                        'chapter_name' => 'test name 1',
                    ],
                ],
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testListKitabsWithoutLogin(): void
    {
        $request = $this->createRequest('GET', '/api/v1/kitabs');
        $request = $this->withHttpBasicAuth($request)->withoutHeader('Authorization');
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_UNAUTHORIZED, $response->getStatusCode());
    }
}
