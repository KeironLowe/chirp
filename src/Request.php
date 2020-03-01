<?php declare(strict_types=1);

namespace KeironLowe\Chirp;

use Zttp\Zttp;
use Zttp\ZttpResponse;

class Request
{


    /**
     * The base url for any API requests.
     */
    const API_BASE = 'https://api.twitter.com/1.1/';


    /**
     * Our request credentials
     *
     * @var Credentials
     */
    private $credentials;


    /**
     * Creates a new instance of Request.
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }


    /**
     * Sends a GET request to the specified endpoint.
     *
     * @param string $endpoint
     * @param array<mixed> $options
     * @return ZttpResponse
     */
    public function get(string $endpoint, array $options): ZttpResponse
    {
        $requestURL = $this->getEndpointUrl($endpoint);

        return Zttp::withHeaders([
            'Authorization' => OAuth::generateAuthorizationHeader('GET', $requestURL, $options, $this->credentials)
        ])->get($requestURL, $options);
    }


    /**
     * Returns a URL for the specified endpoint.
     *
     * @param string $endpoint
     * @return string
     */
    private function getEndpointUrl(string $endpoint): string
    {
        return self::API_BASE . $endpoint . '.json';
    }
}
