<?php declare(strict_types=1);

namespace Chirp;

class Token
{


    /**
     * @var string
     */
    private $method;


    /**
     * @var Credentials
     */
    private $creds;


    /**
     * @var string
     */
    private $url;


    /**
     * @var array<mixed>
     */
    private $params;


    /**
     * Creates a new instance of Token
     *
     * @param mixed ...$args
     */
    private function __construct(...$args)
    {
        $this->method = $args[0];
        $this->url    = $args[1];
        $this->creds  = $args[2];
        $this->params = $args[3];
    }


    /**
     * Creates a new instance and returns the header value.
     *
     * @param Credentials $credentials
     * @param string $method
     * @param string $url
     * @param array<mixed> $params
     * @return string
     */
    public static function create(Credentials $credentials, string $method, string $url, array $params = []): string
    {
        return (new self($method, $url, $credentials, $params))->get();
    }


    /**
     * Returns the Authorization header value.
     *
     * @return string
     */
    protected function get(): string
    {

        // Get the header parameters.
        $parameters = $this->getParameters();

        // Generate a signature based on the parameters and header data.
        $parameters['oauth_signature'] = $this->generateSignature($parameters);

        // Generate the header and return it
        $oAuthHeader = '';
        foreach ($parameters as $header => $value) {
            $oAuthHeader .= $header . '="' . $value . '", ';
        }
        return 'Oauth ' . $oAuthHeader;
    }


    /**
     * Returns an array of required parameters, merged with the request
     * parameters and sorted alphabetically.
     *
     * @return array<string>
     */
    protected function getParameters(): array
    {

        // Merge the required parameters with our own.
        $parameters = array_merge(
            [
                'oauth_token'            => $this->creds->getAccessToken(),
                'oauth_consumer_key'     => $this->creds->getApiKey(),
                'oauth_nonce'            => time(),
                'oauth_timestamp'        => time(),
                'oauth_version'          => '1.0',
                'oauth_signature_method' => 'HMAC-SHA1',
            ],
            $this->params
        );

        ksort($parameters);

        return $parameters;
    }


    /**
     * Generates an OAuth request signature.
     *
     * @param array<mixed> $parameters
     * @return string
     */
    protected function generateSignature(array $parameters): string
    {
        $signatureParams = http_build_query($parameters);
        $signatureBase   = $this->generateSignatureBase($signatureParams);
        $signatureKey    = $this->generateSignatureKey();

        // Hash, encode and return.
        $signature = base64_encode(hash_hmac('sha1', $signatureBase, $signatureKey, true));
        return rawurlencode($signature);
    }


    /**
     * Returns an OAuth request signature base.
     *
     * @param string $params
     * @return string
     */
    protected function generateSignatureBase(string $params): string
    {
        return strtoupper($this->method) . '&' . rawurlencode($this->url) . '&' . rawurlencode($params);
    }


    /**
     * Returns an OAuth request signature key.
     *
     * @return string
     */
    protected function generateSignatureKey(): string
    {
        return rawurlencode($this->creds->getApiSecretKey()) . '&' . rawurlencode($this->creds->getAccessTokenSecret());
    }
}
