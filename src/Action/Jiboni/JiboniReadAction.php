<?php

namespace App\Action\Jiboni;

use App\Domain\Jiboni\Service\JiboniReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class JiboniReadAction
{
    /**
     * @var JiboniReader The jiboni data read from database
     * @var Responder The action response
     */
    private JiboniReader $jiboniReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param JiboniReader $jiboniViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(JiboniReader $jiboniViewer, Responder $responder)
    {
        $this->jiboniReader = $jiboniViewer;
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
        $jiboni = $this->jiboniReader->getJiboniDataById($jiboniId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $jiboni->id,
            'title' => $jiboni->title,
            'desc' => $jiboni->desc,
        ];

        return $this->responder->withJson($response, $data);
    }
}
