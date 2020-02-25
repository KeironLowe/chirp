<?php
namespace KeironLowe\Chirp;

class Credentials
{


    /**
     * The consumer key.
     *
     * @var string
     */
    private $consumerKey;


    /**
     * The consumer secret
     *
     * @var string
     */
    private $consumerSecret;


    /**
     * The access token
     *
     * @var string
     */
    private $accessToken;


    /**
     * The secret secret
     *
     * @var string
     */
    private $accessSecret;


    /**
     * Creates a new instance of Credentials.
     *
     * @param array<string> $credentials
     */
    public function __construct(array $credentials)
    {
        $this->consumerKey    = $credentials['apiKey'];
        $this->consumerSecret = $credentials['apiSecret'];
        $this->accessToken    = $credentials['accessToken'];
        $this->accessSecret   = $credentials['accessSecret'];
    }


    /**
     * Returns the consumer key.
     *
     * @return string
     */
    public function getConsumerKey(): string
    {
        return $this->consumerKey;
    }


    /**
     * Returns the consumer secret
     *
     * @return string
     */
    public function getConsumerSecret(): string
    {
        return $this->consumerSecret;
    }


    /**
     * Returns the access token.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }


    /**
     * Returns the access secret.
     *
     * @return string
     */
    public function getAccessSecret(): string
    {
        return $this->accessSecret;
    }
}
