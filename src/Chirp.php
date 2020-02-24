<?php
namespace KeironLowe\Chirp;

class Chirp
{


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
     * @return Tweet
     */
    public function getTweet(int $tweetId, array $options = []): Tweet
    {
        $parameters = array_merge(['id' => $tweetId, 'tweet_mode' => 'extended'], $options);
        $response   = $this->get('statuses/show', $parameters);

        return new Tweet($response->json());
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
