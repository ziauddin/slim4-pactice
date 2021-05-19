<?php

namespace App\Action\BookList;

use App\Domain\BookList\Service\BookListCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookListCreateAction
{
    /**
     * @var Responder The action responder
     * @var BookListCreator The action
     */
    private Responder $responder;

    private BookListCreator $bookListCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param BookListCreator $bookListCreator The service
     */
    public function __construct(Responder $responder, BookListCreator $bookListCreator)
    {
        $this->responder = $responder;
        $this->bookListCreator = $bookListCreator;
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
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $bookListId = $this->bookListCreator->createBookList($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['bookList_id' => $bookListId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
