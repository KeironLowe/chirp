<?php declare(strict_types=1);

namespace Chirp;

use Chirp\Response;
use Chirp\Credentials;
use Chirp\Endpoints\Lists;

class Chirp
{


    /**
     * @var Credentials
     */
    protected $creds;


    /**
     * @var Http
     */
    protected $http;


    /**
     * Creates a new instance of Chirp.
     *
     * @param array<string>|Credentials $creds
     */
    public function __construct($creds)
    {
        $this->creds = Credentials::factory($creds);
        $this->http  = new Http($this->creds);
    }


    /**
     * Returns a new Lists instance.
     *
     * @return Lists
     */
    public function lists(): Lists
    {
        return new Lists($this->creds);
    }


    /**
     * Sends a GET request to the specified endpoint with parameters.
     *
     * @param string $endpoint
     * @param array<mixed> $params
     * @return Response
     */
    protected function get(string $endpoint, array $params): Response
    {
        return $this->http->get($endpoint, $params);
    }
}
