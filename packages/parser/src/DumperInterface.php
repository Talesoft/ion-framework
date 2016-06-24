<?php
declare(strict_types=1);

namespace Ion;

use Psr\Http\Message\StreamInterface;

interface DumperInterface
{

    public function dump(StreamInterface $stream);
    public function dumpString(): string;
    public function dumpFile(string $path);
}