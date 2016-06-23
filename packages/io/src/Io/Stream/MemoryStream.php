<?php
declare(strict_types=1);

namespace Ion\Io\Stream;

class MemoryStream extends ResourceStream
{

    public function __construct(string $mode = null)
    {

        parent::__construct('php://memory', $mode);
    }
}