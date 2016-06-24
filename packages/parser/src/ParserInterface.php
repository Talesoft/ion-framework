<?php
declare(strict_types=1);

namespace Ion;

use Psr\Http\Message\StreamInterface;

interface ParserInterface
{

    public function parse(StreamInterface $stream);
    public function parseString(string $string);
    public function parseFile(string $path);
}