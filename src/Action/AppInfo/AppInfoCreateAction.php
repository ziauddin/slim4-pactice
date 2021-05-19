<?php

namespace App\Action\AppInfo;

use App\Domain\AppInfo\Service\AppInfoCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class AppInfoCreateAction
{
    /**
     * @var Responder The action responder
     * @var AppInfoCreator The action
     */
    private Responder $responder;

    private AppInfoCreator $appInfoCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param AppInfoCreator $appInfoCreator The service
     */
    public function __construct(Responder $responder, AppInfoCreator $appInfoCreator)
    {
        $this->responder = $responder;
        $this->appInfoCreator = $appInfoCreator;
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
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();
        if (!empty($uploadedFiles)) {
            $data['uploadedFile'] = $uploadedFiles;
        }

        // Invoke the Domain with inputs and retain the result
        $appInfoId = $this->appInfoCreator->createAppInfo($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['appInfo_id' => $appInfoId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
