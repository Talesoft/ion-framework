<?php
declare(strict_types=1);

namespace Ion\Io;

use Ion\Io\Stream\InputStream;
use Ion\Io\Stream\MemoryStream;
use Ion\Io\Stream\OutputStream;
use Ion\Io\Stream\ResourceStream;

class Stream
{

    private function __construct() {}

    public static function create($context, string $mode = null): ResourceStream
    {

        return new ResourceStream($context, $mode);
    }

    public static function createMemory(string $mode = null): MemoryStream
    {

        return new MemoryStream($mode);
    }

    public static function createInput(): InputStream
    {

        return new InputStream();
    }

    public static function createOutput(): OutputStream
    {

        return new OutputStream();
    }
}