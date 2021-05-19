<?php

namespace App\Action\BookContent;

use App\Domain\BookContent\Service\BookContentReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class BookContentReadAction
{
    /**
     * @var BookContentReader The bookContent data read from database
     * @var Responder The action response
     */
    private BookContentReader $bookContentReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param BookContentReader $bookContentViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(BookContentReader $bookContentViewer, Responder $responder)
    {
        $this->bookContentReader = $bookContentViewer;
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
        $bookContent = $this->bookContentReader->getBookContentDataById($bookContentId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $bookContent->id,
            'volume_id' => $bookContent->volume_id,
            'chapter_id' => $bookContent->chapter_id,
            'chapter_name' => $bookContent->chapter_name,
            'description' => $bookContent->description,
            'page_no' => $bookContent->page_no,
            'data_type' => $bookContent->data_type,
            'book_id' => $bookContent->book_id,
        ];

        return $this->responder->withJson($response, $data);
    }
}
