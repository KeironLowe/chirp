<?php
namespace KeironLowe\Chirp;

use Zttp\Zttp;
use Zttp\PendingZttpRequest;

class Chirp
{


    /**
     * The base url for any API requests.
     */
    const API_BASE = 'https://api.twitter.com/1.1/';


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
        $this->credentials = new Credentials($credentials);

        var_dump($this->get('statuses/user_timeline')->json());
    }


    private function get(string $endPoint, array $options = [])
    {
        $requestURL          = self::API_BASE . $endPoint . '.json';
        $authorizationHeader = OAuth::generateAuthorizationHeader('GET', $requestURL, $options, $this->credentials);

        return Zttp::withHeaders([
            'Authorization' => $authorizationHeader
        ])->get($requestURL);
    }
}
