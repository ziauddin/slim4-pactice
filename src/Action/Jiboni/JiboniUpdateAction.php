<?php

namespace App\Action\Jiboni;

use App\Domain\Jiboni\Service\JiboniUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class JiboniUpdateAction
{
    /**
     * @var Responder The responder of the action
     * @var JiboniUpdater The jiboni update service instance
     */
    private Responder $responder;

    private JiboniUpdater $jiboniUpdater;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param JiboniUpdater $jiboniUpdater The service
     */
    public function __construct(Responder $responder, JiboniUpdater $jiboniUpdater)
    {
        $this->responder = $responder;
        $this->jiboniUpdater = $jiboniUpdater;
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
        $jiboniId = (int)$args['jiboni_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->jiboniUpdater->updateJiboni($jiboniId, $data);

        // Build the HTTP response
        return $this->responder->withJson($response);
    }
}