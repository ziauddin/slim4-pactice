<?php

namespace App\Action\Kitab;

use App\Domain\Kitab\Service\KitabCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class KitabCreateAction
{
    /**
     * @var Responder The action responder
     * @var KitabCreator The action
     */
    private Responder $responder;

    private KitabCreator $kitabCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param KitabCreator $kitabCreator The service
     */
    public function __construct(Responder $responder, KitabCreator $kitabCreator)
    {
        $this->responder = $responder;
        $this->kitabCreator = $kitabCreator;
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
        $kitabId = $this->kitabCreator->createKitab($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['kitab_id' => $kitabId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
