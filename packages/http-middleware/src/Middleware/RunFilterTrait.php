<?php
declare(strict_types=1);

namespace Ion\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait RunFilterTrait
{

    protected $request;
    protected $response;
    protected $next;

    protected function run(): ResponseInterface
    {

        return $this->response;
    }

    protected function filter(ResponseInterface $response): ResponseInterface
    {

        return $response;
    }

    protected function handle(): ResponseInterface
    {

        $next = $this->next;
        return $this->filter($next($this->request, $this->run()));
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {

        $this->request = $request;
        $this->response = $response;
        $this->next = $next;

        return $this->handle();
    }
}