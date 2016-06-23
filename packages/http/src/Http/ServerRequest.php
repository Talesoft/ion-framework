<?php
declare(strict_types=1);

namespace Ion\Http;

use Psr\Http\Message\{ServerRequestInterface, StreamInterface};

class ServerRequest extends Request implements ServerRequestInterface
{

    private $attributes;
    private $queryParams;
    private $serverParams;
    private $cookieParams;
    private $uploadedFiles;
    private $parsedBody;

    public function __construct(
        $uri = null,
        string $method = null,
        StreamInterface $body = null,
        array $headers = null,
        string $protocolVersion = null,
        array $serverParams = null,
        array $queryParams = null,
        array $cookieParams = null,
        array $uploadedFiles = null,
        array $attributes = null,
        array $parsedBody = null
    )
    {

        parent::__construct(
            $uri,
            $method,
            $body,
            $headers,
            $protocolVersion
        );

        $this->attributes = $attributes ?: [];
        $this->serverParams = $serverParams ?: [];
        $this->queryParams = $queryParams ?: [];
        $this->cookieParams = $cookieParams ?: [];
        $this->uploadedFiles = $uploadedFiles ?: [];
        $this->parsedBody = null;
    }

    /**
     * {@inheritDoc}
     */
    public function getServerParams()
    {

        return $this->serverParams;
    }

    /**
     * {@inheritDoc}
     */
    public function getCookieParams()
    {

        return $this->cookieParams;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withCookieParams(array $cookies)
    {

        $request = clone $this;
        $request->cookieParams = array_replace_recursive(
            $request->cookieParams,
            $cookies
        );

        return $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getQueryParams()
    {

        return $this->queryParams;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withQueryParams(array $query)
    {

        $request = clone $this;
        $request->queryParams = array_replace_recursive(
            $request->queryParams,
            $query
        );

        return $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getUploadedFiles()
    {

        return $this->uploadedFiles;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withUploadedFiles(array $uploadedFiles)
    {

        $request = clone $this;
        $request->uploadedFiles = array_replace_recursive(
            $request->uploadedFiles,
            $uploadedFiles
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getParsedBody()
    {

        return $this->parsedBody;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withParsedBody($data)
    {

        if (!is_array($data) || !is_object($data))
            throw new \InvalidArgumentException(
                "Structured data should either be an object or an array"
            );

        $request = clone $this;
        $request->parsedBody = $data;

        return $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributes()
    {

        return $this->attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getAttribute($name, $default = null)
    {

        return $this->attributes[$name] ?? $default;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withAttribute($name, $value)
    {
        $request = clone $this;
        $request->attributes[$name] = $value;

        return $request;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withoutAttribute($name)
    {

        $request = clone $this;
        unset($request->attributes[$name]);

        return $request;
    }
}