<?php

namespace App\Action\HayatusSahabaChapter;

use App\Domain\HayatusSahabaChapter\Service\HayatusSahabaChapterReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaChapterReadAction
{
    /**
     * @var HayatusSahabaChapterReader The hayatusSahabaChapter data read from database
     * @var Responder The action response
     */
    private HayatusSahabaChapterReader $hayatusSahabaChapterReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterReader $hayatusSahabaChapterViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaChapterReader $hayatusSahabaChapterViewer, Responder $responder)
    {
        $this->hayatusSahabaChapterReader = $hayatusSahabaChapterViewer;
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
        $hayatusSahabaChapterId = (int)$args['hscid'];

        // Invoke the domain (service class)
        $hayatusSahabaChapter = $this->hayatusSahabaChapterReader->getHayatusSahabaChapterDataById($hayatusSahabaChapterId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $hayatusSahabaChapter->id,
            'book_id' => $hayatusSahabaChapter->book_id,
            'book_name' => $hayatusSahabaChapter->book_name,
            'chapter_id' => $hayatusSahabaChapter->chapter_id,
            'chapter_name' => $hayatusSahabaChapter->chapter_name,
            'chapter_title' => $hayatusSahabaChapter->chapter_title,
            'page_bn' => $hayatusSahabaChapter->page_bn,
            'page_en' => $hayatusSahabaChapter->page_en,
        ];

        return $this->responder->withJson($response, $data);
    }
}
