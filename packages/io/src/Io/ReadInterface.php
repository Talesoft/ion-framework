<?php
declare(strict_types=1);

namespace Ion\Io;

interface ReadInterface extends InputInterface
{

    /**
     * Returns true if the object is at the end of the contents.
     *
     * @return bool
     */
    public function eof();

    /**
     * Returns whether or not the objects contents are readable.
     *
     * @return bool
     */
    public function isReadable();

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     * @throws \RuntimeException if unable to read.
     * @throws \RuntimeException if error occurs while reading.
     */
    public function getContents();
}