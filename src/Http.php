<?php declare(strict_types=1);

namespace Chirp;

use Zttp\Zttp;
use Chirp\Response;

class Http
{


    /**
     * @var Credentials
     */
    protected $creds;


    /**
     * The base url for any API requests.
     */
    const API_BASE = 'https://api.twitter.com/1.1/';


    /**
     * Creates a new instance of HTTP
     *
     * @param Credentials $creds
     */
    public function __construct(Credentials $creds)
    {
        $this->creds = $creds;
    }


    /**
     * Sends a GET request.
     *
     * @param string $endpoint
     * @param array<mixed> $params
     * @return Response
     */
    public function get(string $endpoint, array $params): Response
    {
        [$url, $headers] = $this->getBaseRequestData('GET', $endpoint, $params);
        $response        = Zttp::withHeaders($headers)->get($url, $params);
   
        return new Response($response);
    }


    /**
     * Returns the base required data for the request.
     *
     * @param string $method
     * @param string $endpoint
     * @param array<mixed> $params
     * @return array<int, array<string>|string>
     */
    protected function getBaseRequestData(string $method, string $endpoint, array $params = []): array
    {
        $url = $this->getRequestUrl($endpoint);
        return [
            $url,
            $this->setHeaders('GET', $url, $params)
        ];
    }


    /**
     * Set's the initial headers for the request.
     *
     * @param string $httpMethod
     * @param string $url
     * @param array<mixed> $params
     * @return array<string>
     */
    protected function setHeaders(string $httpMethod, string $url, array $params = []): array
    {
        $headers['Authorization'] = Token::create($this->creds, $httpMethod, $url, $params);
        return $headers;
    }


    /**
     * Returns the full URL for the endpoint.
     *
     * @param string $endpoint
     * @return string
     */
    protected function getRequestUrl(string $endpoint): string
    {
        return self::API_BASE . $endpoint . '.json';
    }
}
