<?php

namespace App\Action\AppInfo;

use App\Domain\AppInfo\Service\AppInfoReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AppInfoReadAction
{
    /**
     * @var AppInfoReader The appInfo data read from database
     * @var Responder The action response
     */
    private AppInfoReader $appInfoReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param AppInfoReader $appInfoViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(AppInfoReader $appInfoViewer, Responder $responder)
    {
        $this->appInfoReader = $appInfoViewer;
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
        $appInfo = $this->appInfoReader->getAppInfoDataById($appInfoId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $appInfo->id,
            'package' => $appInfo->package,
            'app_name' => $appInfo->app_name,
            'app_id' => $appInfo->app_id,
            'app_url' => $appInfo->app_url,
            'app_image' => $appInfo->app_image,
            'rank' => $appInfo->rank,
            'version' => $appInfo->version,
            'update' => $appInfo->update,
        ];

        return $this->responder->withJson($response, $data);
    }
}
