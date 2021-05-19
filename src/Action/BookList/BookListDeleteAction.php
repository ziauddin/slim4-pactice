<?php

namespace App\Action\BookList;

use App\Domain\BookList\Service\BookListDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookListDeleteAction
{
    /**
     * @var BookListDeleter The bookList delete service
     * @var Responder The responder of the delete action
     */
    private BookListDeleter $bookListDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookListDeleter $bookListDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(BookListDeleter $bookListDeleter, Responder $responder)
    {
        $this->bookListDeleter = $bookListDeleter;
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
        $this->bookListDeleter->deleteBookList($bookListId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
