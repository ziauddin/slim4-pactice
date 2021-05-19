<?php

namespace App\Action\ChapterList;

use App\Domain\ChapterList\Service\ChapterListReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ChapterListReadAction
{
    /**
     * @var ChapterListReader The chapterList data read from database
     * @var Responder The action response
     */
    private ChapterListReader $chapterListReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param ChapterListReader $chapterListViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(ChapterListReader $chapterListViewer, Responder $responder)
    {
        $this->chapterListReader = $chapterListViewer;
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
        $chapterList = $this->chapterListReader->getChapterListDataById($chapterListId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $chapterList->id,
            'volume_id' => $chapterList->volume_id,
            'book_name' => $chapterList->book_name,
            'chapter_id' => $chapterList->chapter_id,
            'chapter_name' => $chapterList->chapter_name,
            'chapter_title' => $chapterList->chapter_title,
            'page_bn' => $chapterList->page_bn,
            'page_en' => $chapterList->page_en,
            'book_id' => $chapterList->book_id,
            'active' => $chapterList->active,
        ];

        return $this->responder->withJson($response, $data);
    }
}
