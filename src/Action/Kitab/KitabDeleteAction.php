<?php

namespace App\Action\Kitab;

use App\Domain\Kitab\Service\KitabDeleter;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class KitabDeleteAction
{
    /**
     * @var KitabDeleter The kitab delete service
     * @var Responder The responder of the delete action
     */
    private KitabDeleter $kitabDeleter;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param KitabDeleter $kitabDeleter The service
     * @param Responder $responder The responder
     */
    public function __construct(KitabDeleter $kitabDeleter, Responder $responder)
    {
        $this->kitabDeleter = $kitabDeleter;
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
        $kitabId = (int)$args['kitab_id'];

        // Invoke the domain (service class)
        $this->kitabDeleter->deleteKitab($kitabId);

        // Render the json response
        return $this->responder->withJson($response);
    }
}
