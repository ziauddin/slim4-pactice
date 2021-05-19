<?php

namespace App\Action\VolumeList;

use App\Domain\VolumeList\Service\VolumeListFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class VolumeListFindAction
{
    /**
     * @var VolumeListFinder Find VolumeList
     * @var Responder The response format of the result
     */
    private VolumeListFinder $volumeListFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param VolumeListFinder $volumeListIndex The volumeList index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(VolumeListFinder $volumeListIndex, Responder $responder)
    {
        $this->volumeListFinder = $volumeListIndex;
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

        $volumeLists = $this->volumeListFinder->findVolumeLists($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $volumeListList = [];
        foreach ($volumeLists as $volumeList) {
            $volumeListList[] = [
                'id' => $volumeList->id,
                'book_id' => $volumeList->book_id,
                'volume_id' => $volumeList->volume_id,
                'name' => $volumeList->name,
                'title' => $volumeList->title,
                'has_child' => $volumeList->has_child,
                'chapter_id' => $volumeList->chapter_id,
                'active' => $volumeList->active,
            ];
        }

        return $this->responder->withJson($response, [
            'volumeLists' => $volumeListList,
        ]);
    }
}
