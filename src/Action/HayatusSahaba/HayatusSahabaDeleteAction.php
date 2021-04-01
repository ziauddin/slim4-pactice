<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaDeleteAction
{
    /**
     * @var HayatusSahabaDeleter The hayatusSahaba delete service
     * @var Responder The responder of the delete action
     */
    private HayatusSahabaDeleter $hayatusSahabaDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param HayatusSahabaDeleter $hayatusSahabaDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(HayatusSahabaDeleter $hayatusSahabaDeleter, Responder $responder)
    {
        $this->hayatusSahabaDeleter = $hayatusSahabaDeleter;
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
        $this->hayatusSahabaDeleter->deleteHayatusSahaba($hayatusSahabaId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
