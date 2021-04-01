<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;

/**
 * HttpException middleware 200,201,404,500.
 */
final class HttpExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface  The responseFactoryInterface
     */
    private $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory The responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param ServerRequestInterface $request The request object of http request
     * @param RequestHandlerInterface $handler The request handler method
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {
            // Handle the http exception here
            $statusCode = $httpException->getCode();
            $response = $this->responseFactory->createResponse()->withStatus($statusCode);
            $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());

            $payload = [
                'code' => $statusCode,
                'message' => $errorMessage,
            ];

            // Log the error message
            //$this->logger->error($errorMessage);

            // Render twig template or just add the content to the body
            if (is_string(json_encode($payload, JSON_UNESCAPED_UNICODE))) {
                $response->getBody()->write(
                    json_encode($payload, JSON_UNESCAPED_UNICODE)
                );
            }

            return $response;
        }
    }
}
