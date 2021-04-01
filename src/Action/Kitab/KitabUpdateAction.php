<?php

namespace App\Action\Kitab;

use App\Domain\Kitab\Service\KitabUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class KitabUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var KitabUpdater The kitab update service instance
     */
    private Responder $responder;

    private KitabUpdater $kitabUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param KitabUpdater $kitabUpdater The service
     */
    public function __construct(Responder $responder, KitabUpdater $kitabUpdater)
    {
        $this->responder = $responder;
        $this->kitabUpdater = $kitabUpdater;
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
        $kitabId = (int)$args['kitab_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->kitabUpdater->updateKitab($kitabId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}
