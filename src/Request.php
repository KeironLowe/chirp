<?php
namespace KeironLowe\Chirp;

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
    private static $credentials;


    /**
     * Sets the credentials for this class.
     *
     * @param array $credentials
     * @return void
     */
    public static function setCredentials(array $credentials): void
    {
        static::$credentials = new Credentials($credentials);
    }


    /**
     * Sends a GET request to the specified endpoint.
     *
     * @param string $endpoint
     * @param array $options
     * @return void
     */
    public function get(string $endpoint, array $options)
    {
        $requestURL = $this->getEndpointUrl($endpoint);

        return Zttp::withHeaders([
            'Authorization' => OAuth::generateAuthorizationHeader('GET', $requestURL, $options, static::$credentials)
        ])->get($requestURL);
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
