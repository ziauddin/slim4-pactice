<?php

namespace App\Action\ChapterList;

use App\Domain\ChapterList\Service\ChapterListFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class ChapterListFindAction
{
    /**
     * @var ChapterListFinder Find ChapterList
     * @var Responder The response format of the result
     */
    private ChapterListFinder $chapterListFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param ChapterListFinder $chapterListIndex The chapterList index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(ChapterListFinder $chapterListIndex, Responder $responder)
    {
        $this->chapterListFinder = $chapterListIndex;
        $this->responder = $responder;
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
        $params = (array)$request->getQueryParams();

        $chapterLists = $this->chapterListFinder->findChapterLists($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $chapterListList = [];
        foreach ($chapterLists as $chapterList) {
            $chapterListList[] = [
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
        }

        return $this->responder->withJson($response, [
            'chapterLists' => $chapterListList,
        ]);
    }
}
