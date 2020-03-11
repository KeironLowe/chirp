<?php declare(strict_types=1);

namespace Chirp\Tests\Factories;

use Chirp\Credentials;

class CredentialsFactory
{


    /**
     * Returns a credentials array.
     *
     * @param string $valuesPrefix
     * @return array
     */
    public static function createArray(string $valuesPrefix = ''): array
    {
        return [
            'api_key'             => "{$valuesPrefix}api_key",
            'api_secret_key'      => "{$valuesPrefix}api_secret_key",
            'access_token'        => "{$valuesPrefix}access_token",
            'access_token_secret' => "{$valuesPrefix}access_token_secret"
        ];
    }


    /**
     * Returns a Credentials instance.
     *
     * @param string $valuesPrefix
     * @return Credentials
     */
    public static function createInstance(string $valuesPrefix = ''): Credentials
    {
        return Credentials::factory(self::createArray($valuesPrefix));
    }
}
