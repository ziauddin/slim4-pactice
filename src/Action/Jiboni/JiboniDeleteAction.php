<?php

namespace App\Action\Jiboni;

use App\Domain\Jiboni\Service\JiboniDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class JiboniDeleteAction
{
    /**
     * @var JiboniDeleter The jiboni delete service
     * @var Responder The responder of the delete action
     */
    private JiboniDeleter $jiboniDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param JiboniDeleter $jiboniDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(JiboniDeleter $jiboniDeleter, Responder $responder)
    {
        $this->jiboniDeleter = $jiboniDeleter;
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
        $jiboniId = (int)$args['jiboni_id'];

        // Invoke the domain (service class)
        $this->jiboniDeleter->deleteJiboni($jiboniId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
