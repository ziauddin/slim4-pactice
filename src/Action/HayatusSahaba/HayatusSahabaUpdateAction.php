<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var HayatusSahabaUpdater The hayatusSahaba update service instance
     */
    private Responder $responder;

    private HayatusSahabaUpdater $hayatusSahabaUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param HayatusSahabaUpdater $hayatusSahabaUpdater The service
     */
    public function __construct(Responder $responder, HayatusSahabaUpdater $hayatusSahabaUpdater)
    {
        $this->responder = $responder;
        $this->hayatusSahabaUpdater = $hayatusSahabaUpdater;
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
        $hayatusSahabaId = (int)$args['hsid'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->hayatusSahabaUpdater->updateHayatusSahaba($hayatusSahabaId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
