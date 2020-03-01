<?php declare(strict_types=1);

namespace KeironLowe\Chirp;

class OAuth
{


    /**
     * Generates the OAuth authorization header
     *
     * @param string $method
     * @param string $requestURL
     * @param array<mixed> $options
     * @param Credentials $creds
     * @return string
     */
    public static function generateAuthorizationHeader(string $method, string $requestURL, array $options, Credentials $creds): string
    {

        // Get the parameters and append the signature
        $hashParameters                    = OAuth::getSignatureParameters($creds->getConsumerKey(), $creds->getAccessToken(), $options);
        $hashParameters['oauth_signature'] = OAuth::generateAuthorizationSignature('GET', $requestURL, $options, $creds);

        // Generate the header string
        $oAuthHeader = '';
        foreach ($hashParameters as $header => $value) {
            $oAuthHeader .= $header . '="' . $value . '", ';
        }

        return 'Oauth ' . $oAuthHeader;
    }


    /**
     * Generates a signature for the OAuth a authorization header.
     *
     * @param string $method
     * @param string $requestURL
     * @param array<mixed> $options
     * @param Credentials $creds
     * @return string
     */
    public static function generateAuthorizationSignature(string $method, string $requestURL, array $options, Credentials $creds): string
    {

        // Generate the OAuth parameter hash.
        $hashParameters = OAuth::getSignatureParameters($creds->getConsumerKey(), $creds->getAccessToken(), $options);
        $parametersHash = http_build_query($hashParameters);

        // Generate the base and key
        $signatureBase = OAuth::generateSignatureBase($method, $requestURL, $parametersHash);
        $signatureKey  = OAuth::generateSignatureKey($creds->getConsumerSecret(), $creds->getAccessSecret());

        // Hash, encode and return.
        $signature = base64_encode(hash_hmac('sha1', $signatureBase, $signatureKey, true));
        return rawurlencode($signature);
    }


    /**
     * Returns an array parameters for the OAuth signature.
     *
     * @param string $consumerKey
     * @param string $accessToken
     * @param array<mixed> $options
     * @return array<mixed>
     */
    public static function getSignatureParameters(string $consumerKey, string $accessToken, array $options): array
    {

        // Merge the default parameters with the passed options
        $parameters = array_merge([
            'oauth_token'            => $accessToken,
            'oauth_consumer_key'     => $consumerKey,
            'oauth_nonce'            => time(),
            'oauth_timestamp'        => time(),
            'oauth_version'          => '1.0',
            'oauth_signature_method' => 'HMAC-SHA1',
        ], $options);

        // Sort them alphabetically
        ksort($parameters);

        return $parameters;
    }


    /**
     * Generates the OAuth signature key.
     *
     * @param string $consumerSecret
     * @param string $accessSecret
     * @return string
     */
    public static function generateSignatureKey(string $consumerSecret, string $accessSecret): string
    {
        return rawurlencode($consumerSecret) . '&' . rawurlencode($accessSecret);
    }


    /**
     * Generates the OAuth signature base.
     *
     * @param string $method
     * @param string $requestURL
     * @param string $parametersHash
     * @return string
     */
    public static function generateSignatureBase(string $method, string $requestURL, string $parametersHash): string
    {
        return strtoupper($method) . '&' . rawurlencode($requestURL) . '&' . rawurlencode($parametersHash);
    }
}
