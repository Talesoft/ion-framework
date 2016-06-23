<?php

use Psr\Http\Message\ResponseInterface;
use Ion\Http;
use Ion\Http\{
    Middleware, Middleware\Queue, MiddlewareInterface, Middleware\Dispatcher, Middleware\RunFilterTrait, Response
};

include '../../vendor/autoload.php';

$middleware = [

    //First
    function($request, ResponseInterface $response, Queue $next) {

        $response->getBody()->write("Hello from prepend closure!\n");
        $next->unshift(function($request, ResponseInterface $response, $next) {

            $response->getBody()->write("Hello from inner prepend closure!\n");

            return $next($request, $response);
        });

        return $next($request, $response);
    },

    //Second
    new class implements MiddlewareInterface {
        use RunFilterTrait;

        protected function run(): ResponseInterface
        {

            $this->response->getBody()->write("Hello from anon!\n");
            return $this->response->withHeader('some-header', 'some-value');
        }
    },

    //Third
    function($request, ResponseInterface $response, Queue $next) {

        $response->getBody()->write("Hello from append closure!\n");
        $next->unshift(function($request, ResponseInterface $response, $next) {

            $response->getBody()->write("Hello from inner append closure!\n");

            return $next($request, $response);
        });

        return $next($request, $response);
    },

    //Fourth
    new class implements MiddlewareInterface {
        use RunFilterTrait;

        protected function filter(ResponseInterface $response): ResponseInterface
        {

            $parts = array_map(function($line) {

                return '<span style="color: red">'.$line.'</span>';
            }, explode("\n", (string)$response->getBody()));

            $response->getBody()->rewind();
            $response->getBody()->write(implode("<br>", $parts));

            return $response;
        }
    }
];


$resp = Middleware::dispatchArray($middleware);

echo '<pre>';
var_dump($resp, (string)$resp->getBody());