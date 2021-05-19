<?php

namespace App\Action\ChapterList;

use App\Domain\ChapterList\Service\ChapterListCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ChapterListCreateAction
{
    /**
     * @var Responder The action responder
     * @var ChapterListCreator The action
     */
    private Responder $responder;

    private ChapterListCreator $chapterListCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param ChapterListCreator $chapterListCreator The service
     */
    public function __construct(Responder $responder, ChapterListCreator $chapterListCreator)
    {
        $this->responder = $responder;
        $this->chapterListCreator = $chapterListCreator;
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
        $chapterListId = $this->chapterListCreator->createChapterList($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['chapterList_id' => $chapterListId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
