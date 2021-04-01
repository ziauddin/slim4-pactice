<?php

namespace App\Action\HayatusSahabaChapter;

use App\Domain\HayatusSahabaChapter\Service\HayatusSahabaChapterUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaChapterUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var HayatusSahabaChapterUpdater The hayatusSahabaChapter update service instance
     */
    private Responder $responder;

    private HayatusSahabaChapterUpdater $hayatusSahabaChapterUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param HayatusSahabaChapterUpdater $hayatusSahabaChapterUpdater The service
     */
    public function __construct(Responder $responder, HayatusSahabaChapterUpdater $hayatusSahabaChapterUpdater)
    {
        $this->responder = $responder;
        $this->hayatusSahabaChapterUpdater = $hayatusSahabaChapterUpdater;
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
        $hayatusSahabaChapterId = (int)$args['hscid'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->hayatusSahabaChapterUpdater->updateHayatusSahabaChapter($hayatusSahabaChapterId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
