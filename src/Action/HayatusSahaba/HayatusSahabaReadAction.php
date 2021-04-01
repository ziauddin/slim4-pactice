<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaReadAction
{
    /**
     * @var HayatusSahabaReader The hayatusSahaba data read from database
     * @var Responder The action response
     */
    private HayatusSahabaReader $hayatusSahabaReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaReader $hayatusSahabaViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaReader $hayatusSahabaViewer, Responder $responder)
    {
        $this->hayatusSahabaReader = $hayatusSahabaViewer;
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
        $hayatusSahabaId = (int)$args['hsid'];

        // Invoke the domain (service class)
        $hayatusSahaba = $this->hayatusSahabaReader->getHayatusSahabaDataById($hayatusSahabaId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $hayatusSahaba->id,
            'book_id' => $hayatusSahaba->book_id,
            'chapter_id' => $hayatusSahaba->chapter_id,
            'chapter_name' => $hayatusSahaba->chapter_name,
            'description' => $hayatusSahaba->description,
            'page_no' => $hayatusSahaba->page_no,
        ];

        return $this->responder->withJson($response, $data);
    }
}
