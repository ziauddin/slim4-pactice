<?php

namespace App\Action\Jiboni;

use App\Domain\Jiboni\Service\JiboniCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class JiboniCreateAction
{
    /**
     * @var Responder The action responder
     * @var JiboniCreator The action
     */
    private Responder $responder;

    private JiboniCreator $jiboniCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param JiboniCreator $jiboniCreator The service
     */
    public function __construct(Responder $responder, JiboniCreator $jiboniCreator)
    {
        $this->responder = $responder;
        $this->jiboniCreator = $jiboniCreator;
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
        $jiboniId = $this->jiboniCreator->createJiboni($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['jiboni_id' => $jiboniId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}