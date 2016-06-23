<?php
declare(strict_types=1);

namespace Ion\Io;

interface InputInterface
{

    public function read($length);
}