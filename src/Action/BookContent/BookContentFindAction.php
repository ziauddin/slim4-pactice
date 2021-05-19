<?php

namespace App\Action\BookContent;

use App\Domain\BookContent\Service\BookContentFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookContentFindAction
{
    /**
     * @var BookContentFinder Find BookContent
     * @var Responder The response format of the result
     */
    private BookContentFinder $bookContentFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookContentFinder $bookContentIndex The bookContent index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(BookContentFinder $bookContentIndex, Responder $responder)
    {
        $this->bookContentFinder = $bookContentIndex;
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

        $bookContents = $this->bookContentFinder->findBookContents($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $bookContentList = [];
        foreach ($bookContents as $bookContent) {
            $bookContentList[] = [
                'id' => $bookContent->id,
                'volume_id' => $bookContent->volume_id,
                'chapter_id' => $bookContent->chapter_id,
                'chapter_name' => $bookContent->chapter_name,
                'description' => $bookContent->description,
                'page_no' => $bookContent->page_no,
                'data_type' => $bookContent->data_type,
                'book_id' => $bookContent->book_id,
            ];
        }

        return $this->responder->withJson($response, [
            'bookContents' => $bookContentList,
        ]);
    }
}
