<?php
declare(strict_types=1);

namespace Ion\Http;


use Ion\Http;
use Ion\Http\Middleware\{Dispatcher, DispatcherInterface, Queue};
use Psr\Http\Message\ResponseInterface;

class Middleware
{

    private function __construct() {}

    public function createDispatcher(Queue $queue = null): DispatcherInterface
    {

        return new Dispatcher($queue);
    }

    public static function dispatch(
        DispatcherInterface $dispatcher,
        array $attributes = null
    ): ResponseInterface
    {

        return $dispatcher->dispatch(Http::getServerRequest($attributes), new Response());
    }

    public static function dispatchQueue(Queue $queue): ResponseInterface
    {

        return self::dispatch(self::createDispatcher($queue));
    }

    public static function dispatchArray(array $array): ResponseInterface
    {

        return self::dispatchQueue(Queue::fromArray($array));
    }
}