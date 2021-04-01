<?php

namespace App\Action\HayatusSahaba;

use App\Domain\HayatusSahaba\Service\HayatusSahabaCreator;
use App\Responder\Responder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class HayatusSahabaCreateAction
{
    /**
     * @var Responder The action responder
     * @var HayatusSahabaCreator The action
     */
    private Responder $responder;

    private HayatusSahabaCreator $hayatusSahabaCreator;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     * @param HayatusSahabaCreator $hayatusSahabaCreator The service
     */
    public function __construct(Responder $responder, HayatusSahabaCreator $hayatusSahabaCreator)
    {
        $this->responder = $responder;
        $this->hayatusSahabaCreator = $hayatusSahabaCreator;
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
        $hayatusSahabaId = $this->hayatusSahabaCreator->createHayatusSahaba($data);

        // Build the HTTP response
        return $this->responder
            ->withJson($response, ['hayatusSahaba_id' => $hayatusSahabaId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
