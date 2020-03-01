<?php declare(strict_types=1);

namespace KeironLowe\Chirp;

use Zttp\ZttpResponse;
use KeironLowe\Chirp\Objects\Tweet;

class Chirp
{


    /**
     * The API credentials
     *
     * @var Credentials
     */
    private $credentials;


    /**
     * The object cache.
     *
     * @var array<mixed>
     */
    protected $cache;


    /**
     * Creates a new instance of Chirp.
     *
     * @param array<string> $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = new Credentials($credentials);
    }


    /**
     * Returns a new Lists instance.
     *
     * @return Lists
     */
    public function lists(): Lists
    {
        return new Lists($this->credentials->toArray());
    }


    /**
     * Performs a GET request to the specified endpoint.
     *
     * @param string $endpoint
     * @param array<mixed> $options
     * @return ZttpResponse
     */
    protected function get(string $endpoint, array $options = []): ZttpResponse
    {
        return $this->request()->get($endpoint, $options);
    }


    /**
     * Returns a new instance of Request with the correct credentials.
     *
     * @return Request
     */
    private function request(): Request
    {
        return new Request($this->credentials);
    }


    /**
     * Returns an item from the cache.
     *
     * @param string $id
     * @return mixed
     */
    public function getFromCache(string $id)
    {
        return $this->cache[$id] ?? null;
    }


    /**
     * Adds the data to the cache.
     *
     * @param string $id
     * @param mixed $data
     * @return mixed
     */
    protected function addToCache(string $id, $data)
    {
        $this->cache[$id] = $data;
        return $data;
    }
}
