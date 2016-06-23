<?php
declare(strict_types=1);

namespace Ion\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MiddlewareInterface //implements Psr\Http\Middleware\MiddlewareInterface
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface;
}