<?php

namespace App\Action\Jiboni;

use App\Domain\Jiboni\Service\JiboniFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class JiboniFindAction
{
    /**
     * @var JiboniFinder Find Jiboni
     * @var Responder The response format of the result
     */
    private JiboniFinder $jiboniFinder;

    private Responder $responder;

    /**
     * The constructor.
     *
     * @param JiboniFinder $jiboniIndex The jiboni index list viewer
     * @param Responder $responder The responder
     */
    public function __construct(JiboniFinder $jiboniIndex, Responder $responder)
    {
        $this->jiboniFinder = $jiboniIndex;
        $this->responder = $responder;
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
        $params = (array)$request->getQueryParams();

        $postValue = (array)$request->getParsedBody();
        if (!empty($postValue)) {
            $params = array_merge($params, $postValue);
        }

        $jibonis = $this->jiboniFinder->findJibonis($params);

        // Transform to json response
        // This should be done within a specific Responder class
        $jiboniList = [];
        foreach ($jibonis as $jiboni) {
            $jiboniList[] = [
                'id' => $jiboni->id,
                'ttile' => $jiboni->title,
                'desc' => $jiboni->desc,
            ];
        }

        return $this->responder->withJson($response, [
            'jibonis' => $jiboniList,
        ]);
    }
}
