<?php
declare(strict_types=1);

namespace Ion\Io;

interface SeekInterface
{

    /**
     * Get the size of the objects contents if known.
     *
     * @return int|null Returns the size in bytes if known, or null if unknown.
     */
    public function getSize();

    /**
     * Returns the current position of the object's read/write pointer
     *
     * @return int Position of the file pointer
     * @throws \RuntimeException on error.
     */
    public function tell();

    /**
     * Returns whether or not the object is seekable.
     *
     * @return bool
     */
    public function isSeekable();

    /**
     * Seek to a position in the object.
     *
     * @see http://www.php.net/manual/en/function.fseek.php
     * @param int $offset Stream offset
     * @param int $whence Specifies how the cursor position will be calculated
     *     based on the seek offset. Valid values are identical to the built-in
     *     PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
     *     offset bytes SEEK_CUR: Set position to current location plus offset
     *     SEEK_END: Set position to end-of-stream plus offset.
     * @throws \RuntimeException on failure.
     */
    public function seek($offset, $whence = SEEK_SET);

    /**
     * Seek to the beginning of the stream.
     *
     * If the stream is not seekable, this method will raise an exception;
     * otherwise, it will perform a seek(0).
     *
     * @see seek()
     * @see http://www.php.net/manual/en/function.fseek.php
     * @throws \RuntimeException on failure.
     */
    public function rewind();
}