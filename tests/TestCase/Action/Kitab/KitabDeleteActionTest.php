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
 * @coversDefaultClass \App\Action\Kitab\KitabDeleteAction
 */
class KitabDeleteActionTest extends TestCase
{
    use AppTestTrait;
    use DatabaseTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testDeleteKitab(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createJsonRequest('DELETE', '/api/v1/kitabs/1');
        $request = $this->withHttpBasicAuth($request);

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());

        // Check database
        $this->assertTableRowCount(1, 'db_content');
        $this->assertTableRowNotExists('db_content', 1);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testDeleteInvalidKitab(): void
    {
        $this->insertFixtures([KitabFixture::class]);

        $request = $this->createJsonRequest('DELETE', '/api/v1/kitabs/99');
        $request = $this->withHttpBasicAuth($request);

        $response = $this->app->handle($request);

        // Check response
        $this->assertSame(StatusCodeInterface::STATUS_BAD_REQUEST, $response->getStatusCode());
    }
}
