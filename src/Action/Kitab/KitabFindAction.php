<?php

namespace App\Action\Kitab;

use App\Domain\Kitab\Service\KitabFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class KitabFindAction
{
    /**
     * @var KitabFinder Find Kitab
     * @var Responder The response format of the result
     */
    private KitabFinder $kitabFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param KitabFinder $kitabIndex The kitab index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(KitabFinder $kitabIndex, Responder $responder)
    {
        $this->kitabFinder = $kitabIndex;
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

        $kitabs = $this->kitabFinder->findKitabs($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $kitabList = [];
        foreach ($kitabs as $kitab) {
            $kitabList[] = [
                'id' => $kitab->id,
                'content' => $kitab->content,
                'page_no' => $kitab->page_no,
                'kitab_name' => $kitab->kitab_name,
                'chapter_name' => $kitab->chapter_name,
            ];
        }

        return $this->responder->withJson($response, [
            'kitabs' => $kitabList,
        ]);
    }
}
