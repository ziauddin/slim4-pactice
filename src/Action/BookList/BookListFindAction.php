<?php

namespace App\Action\BookList;

use App\Domain\BookList\Service\BookListFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookListFindAction
{
    /**
     * @var BookListFinder Find BookList
     * @var Responder The response format of the result
     */
    private BookListFinder $bookListFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookListFinder $bookListIndex The bookList index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(BookListFinder $bookListIndex, Responder $responder)
    {
        $this->bookListFinder = $bookListIndex;
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

        $bookLists = $this->bookListFinder->findBookLists($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $bookListList = [];
        foreach ($bookLists as $bookList) {
            $bookListList[] = [
                'id' => $bookList->id,
                'book_name' => $bookList->book_name,
                'author_name' => $bookList->author_name,
                'has_volume' => $bookList->has_volume,
                'rank_no' => $bookList->rank_no,
                'active' => $bookList->active,
            ];
        }

        return $this->responder->withJson($response, [
            'bookLists' => $bookListList,
        ]);
    }
}
