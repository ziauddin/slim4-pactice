<?php

namespace App\Action\VolumeList;

use App\Domain\VolumeList\Service\VolumeListUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class VolumeListUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var VolumeListUpdater The volumeList update service instance
     */
    private Responder $responder;

    private VolumeListUpdater $volumeListUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param VolumeListUpdater $volumeListUpdater The service
     */
    public function __construct(Responder $responder, VolumeListUpdater $volumeListUpdater)
    {
        $this->responder = $responder;
        $this->volumeListUpdater = $volumeListUpdater;
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
        $volumeListId = (int)$args['volumeList_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->volumeListUpdater->updateVolumeList($volumeListId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
