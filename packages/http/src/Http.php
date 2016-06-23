<?php
declare(strict_types=1);

namespace Ion;

use Ion\Io\Stream;
use Psr\Http\Message\{
    MessageInterface, RequestInterface, ResponseInterface, ServerRequestInterface, StreamInterface, UploadedFileInterface, UriInterface
};
use Ion\Http\{AbstractMessage, Verb, ServerRequest, UploadedFile, Uri};

/**
 * Class Http
 *
 * @package Ion
 *
 * @TODO: ALL instances of PSR classes here SHOULD be singletons. They're immutable anyways.
 */
class Http
{

    /**
     * Http constructor.
     */
    private function __construct() {}

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return string|int
     */
    public static function getServerParam(string $name, $default = null)
    {

        return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
    }

    /**
     * @return UriInterface
     */
    public static function getUri(): UriInterface
    {

        /** @var Uri $uri */
        $uri = new Uri();

        $scheme = 'http';
        $https = self::getServerParam('HTTPS');
        if ($https && $https !== 'off')
            $scheme = 'https';

        $uri = $uri->withScheme($scheme);

        $host = self::getServerParam(
            'HTTP_HOST',
            self::getServerParam('SERVER_NAME')
        );

        if (!empty($host))
            $uri = $uri->withHost($host);

        $port = self::getServerParam('SERVER_PORT');
        if (!empty($port))
            $uri = $uri->withPort($port);

        $path = self::getServerParam('PATH_INFO');
        if (empty($path)) {

            $path = self::getServerParam(
                'REDIRECT_REQUEST_URI',
                self::getServerParam('REQUEST_URI')
            );
        }

        if (empty($path))
            $path = '/';

        $pos = null;
        if (($pos = strpos($path, '?')) !== false)
            $path = substr($path, 0, $pos);

        $uri = $uri->withPath($path);

        $query = self::getServerParam(
            'REDIRECT_QUERY_STRING',
            self::getServerParam('QUERY_STRING')
        );

        if (!empty($query))
            $uri = $uri->withQuery($query);

        return $uri;
    }

    /**
     * @return string
     */
    public static function getMethod()
    {

        return self::getServerParam(
            'REQUEST_METHOD',
            Verb::GET
        );
    }

    /**
     * @return StreamInterface
     */
    public static function getBody(): StreamInterface
    {

        return Stream::createInput();
    }

    /**
     * @return string[]
     */
    public static function getHeaders(): array
    {

        $headers = [];
        foreach ($_SERVER as $name => $value) {

            if (strncmp($name, 'HTTP_', 5) === 0) {

                $name = implode('-', array_map(
                    'ucfirst',
                    explode('_', strtolower(substr($name, 5)))
                ));
                $headers[$name] = $value;
                continue;
            }

            if (strncmp($name, 'CONTENT_', 8) === 0) {

                $name = implode('-', array_map(
                    'ucfirst',
                    explode('_', strtolower($name))
                ));

                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    /**
     * @return string
     */
    public static function getProtocolVersion(): string
    {

        list(, $version) = explode('/', self::getServerParam(
            'SERVER_PROTOCOL',
            'HTTP/'.AbstractMessage::DEFAULT_VERSION
        ));

        return $version;
    }

    /**
     * @return string[]
     */
    public static function getQueryParams(): array
    {

        if (!isset($_GET))
            return [];

        return $_GET;
    }

    public static function getBodyParams(): array
    {

        if (!isset($_POST))
            return [];

        return $_POST;
    }

    /**
     * @return string[]
     */
    public static function getCookieParams(): array
    {

        if (!isset($_COOKIE))
            return [];

        return $_COOKIE;
    }

    /**
     * @return UploadedFileInterface[]
     */
    public static function getUploadedFiles(): array
    {

        if (!isset($_FILES))
            return [];

        return self::filterUploadedFiles($_FILES);
    }

    /**
     * @param array $files
     *
     * @return UploadedFileInterface[]
     */
    private static function filterUploadedFiles(array $files): array
    {

        $result = [];
        foreach ($files as $key => $fileInfo) {

            if ($fileInfo instanceof UploadedFileInterface) {

                $result[$key] = $fileInfo;
                continue;
            }

            if (is_array($fileInfo) && isset($fileInfo['tmp_name'])) {

                $result[$key] = self::filterUploadedFile($fileInfo);
                continue;
            }

            if (is_array($fileInfo))
                $result[$key] = self::filterUploadedFiles($fileInfo);

        }

        return $result;
    }

    /**
     * @param array $fileInfo
     *
     * @return UploadedFileInterface
     */
    private static function filterUploadedFile(array $fileInfo): UploadedFileInterface
    {

        if (is_array($fileInfo['tmp_name']))
            return self::filterNestedUploadedFiles($fileInfo);

        return new UploadedFile(
            $fileInfo['tmp_name'],
            $fileInfo['size'],
            $fileInfo['error'],
            $fileInfo['name'],
            $fileInfo['type']
        );
    }

    /**
     * @param array $files
     *
     * @return array
     */
    private static function filterNestedUploadedFiles(array $files): array
    {

        $result = [];
        foreach (array_keys($files['tmp_name']) as $key) {

            $fileInfo = [
                'tmp_name' => $files['tmp_name'][$key],
                'size'     => $files['size'][$key],
                'error'    => $files['error'][$key],
                'name'     => $files['name'][$key],
                'type'     => $files['type'][$key]
            ];

            $result[$key] = self::filterUploadedFile($fileInfo);
        }

        return $result;
    }

    /**
     * @return mixed|\SimpleXMLElement
     */
    public static function parseBody(ServerRequestInterface $request)
    {

        $contentType = $request->getHeaderLine('content-type');
        $body = $request->getBody();

        $data = null;
        if (!$body->eof()) {

            switch (strtolower($contentType)) {
                case 'application/json':

                    $data = json_decode((string)$body);
                    break;
                case 'text/xml':

                    //TODO: replace with tale-dom?
                    $data = simplexml_load_string((string)$body);
                    break;
                case 'multipart/form-data':
                case 'application/x-www-form-urlencoded':

                    parse_str((string)$body, $data);
                    break;
            }
        }

        return $request->withParsedBody($data);
    }

    /**
     * @param array $attributes
     *
     * @return ServerRequestInterface
     */
    public static function getServerRequest(array $attributes = null): ServerRequestInterface
    {

        return new ServerRequest(
            self::getUri(),
            self::getMethod(),
            self::getBody(),
            self::getHeaders(),
            self::getProtocolVersion(),
            $_SERVER,
            self::getQueryParams(),
            self::getCookieParams(),
            self::getUploadedFiles(),
            $attributes,
            self::getBodyParams()
        );
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws \Exception
     */
    public static function emit(ResponseInterface $response)
    {

        if (function_exists('headers_sent') && headers_sent())
            throw new \Exception(
                "Failed to emit response: HTTP headers have already been ".
                "sent to client. Make sure you made no output until ".
                "calling Http::emit"
            );

        $initialHeaderLine = implode(' ', [
            'HTTP/'.$response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ]);

        header($initialHeaderLine, true, $response->getStatusCode());
        foreach ($response->getHeaders() as $name => $value) {

            header("$name: ".implode(',', $value));
        }

        echo (string)$response->getBody();
    }

    /**
     * @param            $uri
     * @param array|null $data
     * @param array|null $headers
     * @param null       $protocolVersion
     * @param null       $options
     *
     * @return ResponseInterface
     */
    public static function get($uri, array $data = null, array $headers = null, $protocolVersion = null, $options = null)
    {

        //TODO: Implement this.
    }

    /**
     * @param            $uri
     * @param array|null $data
     * @param array|null $headers
     * @param null       $protocolVersion
     * @param null       $options
     *
     * @return ResponseInterface
     */
    public static function post($uri, array $data = null, array $headers = null, $protocolVersion = null, $options = null)
    {

        //TODO: Implement this.
    }
}