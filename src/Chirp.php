<?php
namespace KeironLowe\Chirp;

class Chirp
{


    /**
     * The authorization keys and tokens
     *
     * @var Credentials
     */
    private $credentials;


    /**
     * Creates a new instance of Chirp.
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        Request::setCredentials($credentials);
    }


    /**
     * Returns a single Tweet.
     *
     * @param integer $tweetId
     * @param array $options
     * @return void
     */
    public function getTweet(int $tweetId, array $options = [])
    {
        return $this->get('statuses/show', [
            'id' => $tweetId
        ]);
    }


    /**
     * Performs a GET request to the specified endpoint.
     *
     * @param string $endpoint
     * @param array $options
     * @return void
     */
    private function get(string $endpoint, array $options = [])
    {
        return (new Request())->get($endpoint, $options);
    }
}
