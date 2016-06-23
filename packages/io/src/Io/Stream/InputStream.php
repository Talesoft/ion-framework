<?php
declare(strict_types=1);

namespace Ion\Io\Stream;

class InputStream extends ResourceStream
{

    public function __construct()
    {

        parent::__construct('php://input', 'rb');
    }
}