<?php

namespace App\Action\HayatusSahabaChapter;

use App\Domain\HayatusSahabaChapter\Service\HayatusSahabaChapterFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaChapterFindAction
{
    /**
     * @var HayatusSahabaChapterFinder The hayatus sahaba chapter finder
     * @var Responder The response of this action
     */
    private HayatusSahabaChapterFinder $hayatusSahabaChapterFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterFinder $hayatusSahabaChapterIndex The hayatusSahabaChapter index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaChapterFinder $hayatusSahabaChapterIndex, Responder $responder)
    {
        $this->hayatusSahabaChapterFinder = $hayatusSahabaChapterIndex;
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
        $postValue = (array)$request->getParsedBody();
        if (!empty($postValue)) {
            $params = array_merge($params, $postValue);
        }
        $hayatusSahabaChapters = $this->hayatusSahabaChapterFinder->findHayatusSahabaChapters($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $hayatusSahabaChapterList = [];
        foreach ($hayatusSahabaChapters as $hayatusSahabaChapter) {
            $hayatusSahabaChapterList[] = [
                'id' => $hayatusSahabaChapter->id,
                'book_id' => $hayatusSahabaChapter->book_id,
                'book_name' => $hayatusSahabaChapter->book_name,
                'chapter_id' => $hayatusSahabaChapter->chapter_id,
                'chapter_name' => $hayatusSahabaChapter->chapter_name,
                'chapter_title' => $hayatusSahabaChapter->chapter_title,
                'page_bn' => $hayatusSahabaChapter->page_bn,
                'page_en' => $hayatusSahabaChapter->page_en,
            ];
        }

        return $this->responder->withJson($response, [
            'hayatusSahabaChapters' => $hayatusSahabaChapterList,
        ]);
    }
}
