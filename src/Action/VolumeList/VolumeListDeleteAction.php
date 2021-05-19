<?php

namespace App\Action\VolumeList;

use App\Domain\VolumeList\Service\VolumeListDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class VolumeListDeleteAction
{
    /**
     * @var VolumeListDeleter The volumeList delete service
     * @var Responder The responder of the delete action
     */
    private VolumeListDeleter $volumeListDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param VolumeListDeleter $volumeListDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(VolumeListDeleter $volumeListDeleter, Responder $responder)
    {
        $this->volumeListDeleter = $volumeListDeleter;
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
        $volumeListId = (int)$args['volumeList_id'];

        // Invoke the domain (service class)
        $this->volumeListDeleter->deleteVolumeList($volumeListId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
