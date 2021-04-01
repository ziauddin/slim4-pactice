<?php

namespace App\Action\HayatusSahabaChapter;

use App\Domain\HayatusSahabaChapter\Service\HayatusSahabaChapterCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaChapterCreateAction
{
    /**
     * @var Responder The action responder
     * @var HayatusSahabaChapterCreator The action
     */
    private Responder $responder;

    private HayatusSahabaChapterCreator $hayatusSahabaChapterCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param HayatusSahabaChapterCreator $hayatusSahabaChapterCreator The service
     */
    public function __construct(Responder $responder, HayatusSahabaChapterCreator $hayatusSahabaChapterCreator)
    {
        $this->responder = $responder;
        $this->hayatusSahabaChapterCreator = $hayatusSahabaChapterCreator;
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
        $hayatusSahabaChapterId = $this->hayatusSahabaChapterCreator->createHayatusSahabaChapter($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['hayatusSahabaChapter_id' => $hayatusSahabaChapterId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
