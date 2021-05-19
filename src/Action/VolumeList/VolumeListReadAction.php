<?php

namespace App\Action\VolumeList;

use App\Domain\VolumeList\Service\VolumeListReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class VolumeListReadAction
{
    /**
     * @var VolumeListReader The volumeList data read from database
     * @var Responder The action response
     */
    private VolumeListReader $volumeListReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param VolumeListReader $volumeListViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(VolumeListReader $volumeListViewer, Responder $responder)
    {
        $this->volumeListReader = $volumeListViewer;
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
        $volumeList = $this->volumeListReader->getVolumeListDataById($volumeListId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $volumeList->id,
            'book_id' => $volumeList->book_id,
            'volume_id' => $volumeList->volume_id,
            'name' => $volumeList->name,
            'title' => $volumeList->title,
            'has_child' => $volumeList->has_child,
            'chapter_id' => $volumeList->chapter_id,
            'active' => $volumeList->active,
        ];

        return $this->responder->withJson($response, $data);
    }
}
