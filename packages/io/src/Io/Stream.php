<?php
declare(strict_types=1);

namespace Ion\Io;

use Ion\Io\Stream\InputStream;
use Ion\Io\Stream\MemoryStream;
use Ion\Io\Stream\OutputStream;

class Stream
{

    private function __construct() {}

    public static function create($context, string $mode = null)
    {

        return new ResourceStream($context, $mode);
    }

    public static function createMemory(string $mode = null)
    {

        return new MemoryStream($mode);
    }

    public static function createInput()
    {

        return new InputStream();
    }

    public static function createOutput()
    {

        return new OutputStream();
    }
}