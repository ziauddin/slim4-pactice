<?php

namespace App\Action\Kitab;

use App\Domain\Kitab\Service\KitabReader;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class KitabReadAction
{
    /**
     * @var KitabReader The kitab data read from database
     * @var Responder The action response
     */
    private KitabReader $kitabReader;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param KitabReader $kitabViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(KitabReader $kitabViewer, Responder $responder)
    {
        $this->kitabReader = $kitabViewer;
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
        $kitab = $this->kitabReader->getKitabDataById($kitabId);
        // Transform to json response
        // This should be done within a specific Responder class
        $data = [
            'id' => $kitab->id,
            'content' => $kitab->content,
            'page_no' => $kitab->page_no,
            'kitab_name' => $kitab->kitab_name,
            'chapter_name' => $kitab->chapter_name,
        ];

        return $this->responder->withJson($response, $data);
    }
}
