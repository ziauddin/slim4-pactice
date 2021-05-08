<?php

namespace App\Action\AppInfo;

use App\Domain\AppInfo\Service\AppInfoFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AppInfoFindAction
{
    /**
     * @var AppInfoFinder Find AppInfo
     * @var Responder The response format of the result
     */
    private AppInfoFinder $appInfoFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param AppInfoFinder $appInfoIndex The appInfo index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(AppInfoFinder $appInfoIndex, Responder $responder)
    {
        $this->appInfoFinder = $appInfoIndex;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = (array)$request->getQueryParams();

        $appInfos = $this->appInfoFinder->findAppInfos($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $appInfoList = [];
        foreach ($appInfos as $appInfo) {
            $appInfoList[] = [
                'id' => $appInfo->id,
                'package' => $appInfo->package,
                'app_name' => $appInfo->app_name,
                'app_id' => $appInfo->app_id,
                'app_url' => $appInfo->app_url,
                'app_image' => $appInfo->app_image,
                'rank' => $appInfo->rank,
                'version' => $appInfo->version,
                'update' => $appInfo->update
            ];
        }

        return $this->responder->withJson($response, [
            'appInfos' => $appInfoList,
        ]);
    }
}