<?php

namespace Tests;

use Core\Env;
use HttpSoft\Message\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiTestCase extends TestCase
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        define('__ROOT__', __DIR__ . '/..');
        require_once __ROOT__ . '/Bootstrap/requires.php';
    }

    public function runRequest(ServerRequestInterface $request): ResponseInterface
    {
        return Env::get()->router->run($request);
    }

    public function get(string $uri, array $headers = [], bool $jsonDecodeBody = true): ResponseInterface|array
    {
        $response = $this->runRequest(new ServerRequest(method: 'GET', uri: $uri, headers: $headers));

        if ($jsonDecodeBody) {
            return $this->jsonDecodeBody($response);
        }

        return $response;
    }

    public function post(string $uri, mixed $body = null, array $headers = [], bool $jsonDecodeBody = true): ResponseInterface|array
    {
        $request = new ServerRequest(method: 'POST', uri: $uri, headers: $headers);

        if ($body !== null) {
            $request->getBody()->write(json_encode($body));
        }

        $response = $this->runRequest($request);

        if ($jsonDecodeBody) {
            return $this->jsonDecodeBody($response);
        }

        return $response;
    }

    public function jsonDecodeBody(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
