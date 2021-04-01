<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaFindAction
{
    private HayatusSahabaFinder $hayatusSahabaFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaFinder $hayatusSahabaIndex The hayatusSahaba index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaFinder $hayatusSahabaIndex, Responder $responder)
    {
        $this->hayatusSahabaFinder = $hayatusSahabaIndex;
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
        $postValue = (array)$request->getParsedBody();
        if (!empty($postValue)) {
            $params = array_merge($params, $postValue);
        }
        $hayatusSahabas = $this->hayatusSahabaFinder->findHayatusSahabas($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $hayatusSahabaList = [];
        foreach ($hayatusSahabas as $hayatusSahaba) {
            $hayatusSahabaList[] = [
                'id' => $hayatusSahaba->id,
                'book_id' => $hayatusSahaba->book_id,
                'chapter_id' => $hayatusSahaba->chapter_id,
                'chapter_name' => $hayatusSahaba->chapter_name,
                'description' => $hayatusSahaba->description,
                'page_no' => $hayatusSahaba->page_no,
            ];
        }

        return $this->responder->withJson($response, [
            'hayatusSahabas' => $hayatusSahabaList,
        ]);
    }
}
