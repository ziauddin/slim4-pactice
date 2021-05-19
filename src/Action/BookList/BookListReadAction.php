<?php

namespace App\Action\BookList;

use App\Domain\BookList\Service\BookListReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookListReadAction
{
    /**
     * @var BookListReader The bookList data read from database
     * @var Responder The action response
     */
    private BookListReader $bookListReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookListReader $bookListViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(BookListReader $bookListViewer, Responder $responder)
    {
        $this->bookListReader = $bookListViewer;
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
        $bookListId = (int)$args['bookList_id'];

        // Invoke the domain (service class)
        $bookList = $this->bookListReader->getBookListDataById($bookListId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $bookList->id,
            'book_name' => $bookList->book_name,
            'author_name' => $bookList->author_name,
            'has_volume' => $bookList->has_volume,
            'rank_no' => $bookList->rank_no,
            'active' => $bookList->active,
        ];

        return $this->responder->withJson($response, $data);
    }
}
