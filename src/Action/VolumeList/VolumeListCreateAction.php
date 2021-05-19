<?php

namespace App\Action\VolumeList;

use App\Domain\VolumeList\Service\VolumeListCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class VolumeListCreateAction
{
    /**
     * @var Responder The action responder
     * @var VolumeListCreator The action
     */
    private Responder $responder;

    private VolumeListCreator $volumeListCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param VolumeListCreator $volumeListCreator The service
     */
    public function __construct(Responder $responder, VolumeListCreator $volumeListCreator)
    {
        $this->responder = $responder;
        $this->volumeListCreator = $volumeListCreator;
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

        // Invoke the Domain with inputs and retain the result
        $volumeListId = $this->volumeListCreator->createVolumeList($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['volumeList_id' => $volumeListId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
