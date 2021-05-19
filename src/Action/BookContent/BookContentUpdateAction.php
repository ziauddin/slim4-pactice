<?php

namespace App\Action\BookContent;

use App\Domain\BookContent\Service\BookContentUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookContentUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var BookContentUpdater The bookContent update service instance
     */
    private Responder $responder;

    private BookContentUpdater $bookContentUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param BookContentUpdater $bookContentUpdater The service
     */
    public function __construct(Responder $responder, BookContentUpdater $bookContentUpdater)
    {
        $this->responder = $responder;
        $this->bookContentUpdater = $bookContentUpdater;
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
        $bookContentId = (int)$args['bookContent_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->bookContentUpdater->updateBookContent($bookContentId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
