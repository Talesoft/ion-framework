<?php
declare(strict_types=1);

namespace Ion\Http;

class Verb
{

    const GET = 'GET';
    const POST = 'POST';
    const HEAD = 'HEAD';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const TRACE = 'TRACE';
    const OPTIONS = 'OPTIONS';
    const CONNECT = 'CONNECT';

    private function __construct() {}
}