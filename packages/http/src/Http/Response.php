<?php
declare(strict_types=1);

namespace Ion\Http;

use InvalidArgumentException;
use Psr\Http\Message\{ResponseInterface, StreamInterface};

class Response extends AbstractMessage implements ResponseInterface
{

    const DEFAULT_STATUS_CODE = StatusCode::OK;

    private $statusCode;
    private $reasonPhrase;

    public function __construct(
        StreamInterface $body = null,
        $statusCode = null,
        array $headers = null,
        string $reasonPhrase = null,
        string $protocolVersion = null
    )
    {
        parent::__construct($body, $headers, $protocolVersion);

        $this->statusCode = $statusCode !== null
                           ? $this->filterStatusCode($statusCode)
                           : self::DEFAULT_STATUS_CODE;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusCode()
    {

        return $this->statusCode;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function withStatus($code, $reasonPhrase = '')
    {

        $response = clone $this;
        $response->statusCode = $this->filterStatusCode($code);

        if (!empty($reasonPhrase))
            $response->reasonPhrase = $reasonPhrase;

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getReasonPhrase()
    {

        if (empty($this->reasonPhrase))
            return StatusCode::getReasonPhrase($this->statusCode);

        return $this->reasonPhrase;
    }

    private function filterStatusCode($code): int
    {

        if (is_string($code) && is_numeric($code))
            $code = intval($code);

        if (is_string($code) && defined(StatusCode::class."::$code"))
            $code = constant(StatusCode::class."::$code");

        if (!is_int($code))
            throw new InvalidArgumentException(
                "StatusCode needs to be an integer, numeric string or a name ".
                "of a ".StatusCode::class." constant"
            );

        if ($code < 100 || $code > 599)
            throw new InvalidArgumentException(
                "StatusCode needs to be a valid HTTP status code. ".
                "It's usually a number between 100 and 600"
            );

        return $code;
    }
}