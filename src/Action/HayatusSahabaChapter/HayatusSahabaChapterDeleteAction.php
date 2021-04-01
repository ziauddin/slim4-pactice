<?php

namespace App\Action\HayatusSahabaChapter;

use App\Domain\HayatusSahabaChapter\Service\HayatusSahabaChapterDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaChapterDeleteAction
{
    /**
     * @var HayatusSahabaChapterDeleter The hayatusSahabaChapter delete service
     * @var Responder The responder of the delete action
     */
    private HayatusSahabaChapterDeleter $hayatusSahabaChapterDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaChapterDeleter $hayatusSahabaChapterDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaChapterDeleter $hayatusSahabaChapterDeleter, Responder $responder)
    {
        $this->hayatusSahabaChapterDeleter = $hayatusSahabaChapterDeleter;
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
        $this->hayatusSahabaChapterDeleter->deleteHayatusSahabaChapter($hayatusSahabaChapterId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
