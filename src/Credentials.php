<?php declare(strict_types=1);

namespace Chirp;

use InvalidArgumentException;

class Credentials
{


    /**
     * @var string
     */
    private $apiKey;


    /**
     * @var string
     */
    private $apiSecretKey;


    /**
     * @var string
     */
    private $accessToken;


    /**
     * @var string
     */
    private $accessTokenSecret;


    /**
     * Creates a new instance of Credentials.
     *
     * @param array<string> $credentials
     */
    private function __construct(array $credentials)
    {
        $this->apiKey            = $credentials['api_key'];
        $this->apiSecretKey      = $credentials['api_secret_key'];
        $this->accessToken       = $credentials['access_token'];
        $this->accessTokenSecret = $credentials['access_token_secret'];
    }


    /**
     * Returns the API Key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }


    /**
     * Returns the API Key.
     *
     * @return string
     */
    public function getApiSecretKey(): string
    {
        return $this->apiSecretKey;
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
     * Returns the access token secret.
     *
     * @return string
     */
    public function getAccessTokenSecret(): string
    {
        return $this->accessTokenSecret;
    }


    /**
     * Returns the credentials an array.
     *
     * @return array<string>
     */
    public function toArray(): array
    {
        return [
            'api_key'             => $this->getApiKey(),
            'api_secret_key'      => $this->getApiSecretKey(),
            'access_token'        => $this->getAccessToken(),
            'access_token_secret' => $this->getAccessTokenSecret()
        ];
    }


    /**
     * Returns a new instance of this class.
     *
     * @param array<string>|Credentials $credentials
     * @return Credentials
     */
    public static function create($credentials): Credentials
    {
        if (!Credentials::areInAValidFormat($credentials)) {
            throw new InvalidArgumentException('Provided credentials are not in a valid format');
        }

        if (is_array($credentials)) {
            $credentials = new self($credentials);
        }
    
        return $credentials;
    }


    /**
     * Returns true if credentials are in valid format.
     *
     * @param array<string>|Credentials $creds
     * @return boolean
     */
    private static function areInAValidFormat($creds): bool
    {
        $isValid = false;

        if (is_array($creds)) {
            $isValid = Credentials::hasRequiredValues($creds);
        }

        if (is_object($creds)) {
            $isValid = is_a($creds, Credentials::class);
        }

        return $isValid;
    }


    /**
     * Checks if the credentials array has the required values.
     *
     * @param array<string> $creds
     * @return boolean
     */
    private static function hasRequiredValues(array $creds): bool
    {
        return isset(
            $creds['api_key'],
            $creds['api_secret_key'],
            $creds['access_token'],
            $creds['access_token_secret']
        );
    }
}
