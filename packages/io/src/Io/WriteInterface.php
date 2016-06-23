<?php
declare(strict_types=1);

namespace Ion\Io;

interface WriteInterface extends OutputInterface
{

    /**
     * Returns whether or not the object-contents are writable.
     *
     * @return bool
     */
    public function isWritable();
}