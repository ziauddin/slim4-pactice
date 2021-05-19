<?php

namespace App\Action\ChapterList;

use App\Domain\ChapterList\Service\ChapterListUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ChapterListUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var ChapterListUpdater The chapterList update service instance
     */
    private Responder $responder;

    private ChapterListUpdater $chapterListUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param ChapterListUpdater $chapterListUpdater The service
     */
    public function __construct(Responder $responder, ChapterListUpdater $chapterListUpdater)
    {
        $this->responder = $responder;
        $this->chapterListUpdater = $chapterListUpdater;
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
        $chapterListId = (int)$args['chapterList_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->chapterListUpdater->updateChapterList($chapterListId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
