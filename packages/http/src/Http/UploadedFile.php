<?php

namespace Ion\Http;

use Ion\Io\ResourceStream;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{

    const ERROR_OK = \UPLOAD_ERR_OK;
    const ERROR_INI_SIZE = \UPLOAD_ERR_INI_SIZE;
    const ERROR_FORM_SIZE = \UPLOAD_ERR_FORM_SIZE;
    const ERROR_PARTIAL = \UPLOAD_ERR_PARTIAL;
    const ERROR_NO_FILE = \UPLOAD_ERR_NO_FILE;
    const ERROR_NO_TMP_DIR = \UPLOAD_ERR_NO_TMP_DIR;
    const ERROR_CANT_WRITE = \UPLOAD_ERR_CANT_WRITE;
    const ERROR_EXTENSION = \UPLOAD_ERR_EXTENSION;


    private $path;
    private $size;
    private $error;
    private $clientFilename;
    private $clientMediaType;


    public function __construct(
        $path,
        $size,
        $error,
        $clientFilename,
        $clientMediaType
    )
    {

        $this->path = $path;
        $this->size = intval($size);
        $this->error = intval($error);
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    /**
     * {@inheritDoc}
     */
    public function getStream()
    {

        if (!file_exists($this->path))
            throw new \RuntimeException(
                "The uploaded file has already been moved"
            );

        return new ResourceStream($this->path, 'rb+');
    }

    /**
     * {@inheritDoc}
     *
     * @TODO: Writable checks
     */
    public function moveTo($targetPath)
    {

        if (empty(PHP_SAPI) || strncmp('cli', PHP_SAPI, 3) === 0) {

            file_put_contents($targetPath, (string)$this->getStream());
        } else {

            move_uploaded_file($this->path, $targetPath);
        }

        unlink($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {

        return $this->size;
    }

    /**
     * {@inheritDoc}
     */
    public function getError()
    {

        return $this->error;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientFilename()
    {

        return $this->clientFilename;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientMediaType()
    {

        return $this->clientMediaType;
    }
}