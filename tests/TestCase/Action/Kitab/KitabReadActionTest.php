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
 * @coversDefaultClass \App\Action\Kitab\KitabReadAction
 */
class KitabReadActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testValidId(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createRequest('GET', '/api/v1/kitabs/1');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertJsonContentType($response);
        $this->assertJsonData(
            [
                'id' => 1,
                'content' => 'content the is very intersting not sure what happened',
                'page_no' => '25',
                'kitab_name' => 'Kitab name 1',
                'chapter_name' => 'test name 1',
            ],
            $response
        );
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidId(): void
    {
        $request = $this->createRequest('GET', '/api/v1/kitabs/99');
        $request = $this->withHttpBasicAuth($request);
        $response = $this->app->handle($request);

        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
