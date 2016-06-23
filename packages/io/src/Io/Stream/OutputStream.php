<?php
declare(strict_types=1);

namespace Ion\Io\Stream;

class OutputStream extends ResourceStream
{

    public function __construct()
    {

        parent::__construct('php://output', 'wb');
    }
}