<?php
declare(strict_types=1);

namespace Ion\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Queue extends \SplQueue
{


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        if (count($this) < 1)
            return $response;

        $middleware = $this->dequeue();
        $response = $middleware($request, $response, $this);

        return $response;
    }

    public static function fromArray(array $array): Queue
    {

        $queue = new static();
        foreach ($array as $value)
            $queue->enqueue($value);

        return $queue;
    }
}