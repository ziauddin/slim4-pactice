<?php

namespace App\Action\ChapterList;

use App\Domain\ChapterList\Service\ChapterListDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ChapterListDeleteAction
{
    /**
     * @var ChapterListDeleter The chapterList delete service
     * @var Responder The responder of the delete action
     */
    private ChapterListDeleter $chapterListDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param ChapterListDeleter $chapterListDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(ChapterListDeleter $chapterListDeleter, Responder $responder)
    {
        $this->chapterListDeleter = $chapterListDeleter;
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
        $chapterListId = (int)$args['chapterList_id'];

        // Invoke the domain (service class)
        $this->chapterListDeleter->deleteChapterList($chapterListId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
