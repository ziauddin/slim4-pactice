<?php

namespace App\Action\BookContent;

use App\Domain\BookContent\Service\BookContentDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookContentDeleteAction
{
    /**
     * @var BookContentDeleter The bookContent delete service
     * @var Responder The responder of the delete action
     */
    private BookContentDeleter $bookContentDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookContentDeleter $bookContentDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(BookContentDeleter $bookContentDeleter, Responder $responder)
    {
        $this->bookContentDeleter = $bookContentDeleter;
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
        $bookContentId = (int)$args['bookContent_id'];

        // Invoke the domain (service class)
        $this->bookContentDeleter->deleteBookContent($bookContentId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
