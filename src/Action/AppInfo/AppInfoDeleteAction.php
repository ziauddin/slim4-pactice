<?php

namespace App\Action\AppInfo;

use App\Domain\AppInfo\Service\AppInfoDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AppInfoDeleteAction
{
    /**
     * @var AppInfoDeleter The appInfo delete service
     * @var Responder The responder of the delete action
     */
    private AppInfoDeleter $appInfoDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param AppInfoDeleter $appInfoDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(AppInfoDeleter $appInfoDeleter, Responder $responder)
    {
        $this->appInfoDeleter = $appInfoDeleter;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The routing arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $appInfoId = (int)$args['appInfo_id'];

        // Invoke the domain (service class)
        $this->appInfoDeleter->deleteAppInfo($appInfoId);

        $result = ['status' => 200, 'message' => "app info delete successfully"];

        // Render the json response
        return $this->responder->withJson($response, $result);
    }
}