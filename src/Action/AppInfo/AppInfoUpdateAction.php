<?php

namespace App\Action\AppInfo;

use App\Domain\AppInfo\Service\AppInfoUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AppInfoUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var AppInfoUpdater The appInfo update service instance
     */
    private Responder $responder;

    private AppInfoUpdater $appInfoUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param AppInfoUpdater $appInfoUpdater The service
     */
    public function __construct(Responder $responder, AppInfoUpdater $appInfoUpdater)
    {
        $this->responder = $responder;
        $this->appInfoUpdater = $appInfoUpdater;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $appInfoId = (int)$args['appInfo_id'];
        $data = (array)$request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        if (!empty($uploadedFiles)) {
            $data['uploadedFile'] = $uploadedFiles;
        }
        //echo $appInfoId;
        //die(var_dump($data));

        // Invoke the Domain with inputs and retain the result
        $this->appInfoUpdater->updateAppInfo($appInfoId, $data);

        $result = ['status' => 200, 'message' => 'AppInfo Update successfully'];

        // Build the HTTP response
        return $this->responder->withJson($response, $result);
    }
}
