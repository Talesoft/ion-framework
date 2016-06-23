<?php
declare(strict_types=1);

namespace Ion\Http\Middleware;

use Ion\Http\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface DispatcherInterface extends MiddlewareInterface
{
    public function append(callable $middleware): DispatcherInterface;
    public function prepend(callable $middleware): DispatcherInterface;
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}