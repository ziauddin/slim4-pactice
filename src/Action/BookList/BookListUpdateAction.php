<?php

namespace App\Action\BookList;

use App\Domain\BookList\Service\BookListUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookListUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var BookListUpdater The bookList update service instance
     */
    private Responder $responder;

    private BookListUpdater $bookListUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param BookListUpdater $bookListUpdater The service
     */
    public function __construct(Responder $responder, BookListUpdater $bookListUpdater)
    {
        $this->responder = $responder;
        $this->bookListUpdater = $bookListUpdater;
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
        $bookListId = (int)$args['bookList_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->bookListUpdater->updateBookList($bookListId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
