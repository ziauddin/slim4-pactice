<?php

namespace App\Action\BookContent;

use App\Domain\BookContent\Service\BookContentCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookContentCreateAction
{
    /**
     * @var Responder The action responder
     * @var BookContentCreator The action
     */
    private Responder $responder;

    private BookContentCreator $bookContentCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param BookContentCreator $bookContentCreator The service
     */
    public function __construct(Responder $responder, BookContentCreator $bookContentCreator)
    {
        $this->responder = $responder;
        $this->bookContentCreator = $bookContentCreator;
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
        $bookContentId = $this->bookContentCreator->createBookContent($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['bookContent_id' => $bookContentId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
