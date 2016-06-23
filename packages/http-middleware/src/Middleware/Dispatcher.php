<?php
declare(strict_types=1);

namespace Ion\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher implements DispatcherInterface
{
    use RunFilterTrait;

    private $queue;

    public function __construct(Queue $queue = null)
    {

        $this->queue = $queue ?: new Queue();
    }

    public function append(callable $middleware): DispatcherInterface
    {

        $this->queue->enqueue($middleware);

        return $this;
    }

    public function prepend(callable $middleware): DispatcherInterface
    {

        $this->queue->unshift($middleware);

        return $this;
    }

    public function dispatch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $queue = $this->queue;
        return $queue($request, $response);
    }

    protected function run(): ResponseInterface
    {

        return $this->dispatch($this->request, $this->response);
    }
}