<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaWithChapter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaWithChapterAction
{
    private HayatusSahabaWithChapter $hayatusSahabaChapter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param HayatusSahabaWithChapter $hayatusSahabaChapter The hayatusSahabaChapters list
     */
    public function __construct(HayatusSahabaWithChapter $hayatusSahabaChapter, Responder $responder)
    {
        $this->hayatusSahabaChapter = $hayatusSahabaChapter;
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
        $hayatusSahabaChapters = $this->hayatusSahabaChapter->getAllHayatusSahabaChapter($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $hayatusSahabaList = [];
        foreach ($hayatusSahabaChapters['hayatusSahabas'] as $hayatusSahaba) {
            $hayatusSahabaList[] = [
                'id' => $hayatusSahaba->id,
                'book_id' => $hayatusSahaba->book_id,
                'chapter_id' => $hayatusSahaba->chapter_id,
                'chapter_name' => $hayatusSahaba->chapter_name,
                'description' => $hayatusSahaba->description,
                'page_no' => $hayatusSahaba->page_no,
            ];
        }

        $hayatusSahabaChapterList = [];
        foreach ($hayatusSahabaChapters['hayatusSahabaChapters'] as $hayatusSahabaChapter) {
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
            'hayatusSahabas' => $hayatusSahabaList, 'hayatusSahabaChapters' => $hayatusSahabaChapterList,
        ]);
    }
}
