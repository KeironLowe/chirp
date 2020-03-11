<?php declare(strict_types=1);

namespace Chirp\Tests;

use Chirp\Chirp;
use Chirp\Credentials;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Chirp\Tests\Factories\CredentialsFactory;

final class CredentialsTest extends TestCase
{


    /**
     * Tests that an exception is thrown if the credentials argument is invalid
     *
     * @return void
     */
    public function testExceptionThrownForInvalidCredentialsType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Credentials::factory('');
    }


    /**
     * Tests that an exception is thrown if a credentials array is missing
     * values
     *
     * @return void
     */
    public function testExceptionThrownForMissingCredentials(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Credentials::factory([]);
    }


    /**
     * Tests that the getX methods return the correct values.
     *
     * @return void
     */
    public function testGetMethodsReturnCorrectValues(): void
    {
        $creds = CredentialsFactory::createInstance('test_');

        $this->assertEquals('test_api_key', $creds->getApiKey());
        $this->assertEquals('test_api_secret_key', $creds->getApiSecretKey());
        $this->assertEquals('test_access_token', $creds->getAccessToken());
        $this->assertEquals('test_access_token_secret', $creds->getAccessTokenSecret());
    }


    /**
     * Tests that the toArray method returns the correct values.
     *
     * @return void
     */
    public function testToArrayReturnsCorrectValues(): void
    {
        $creds      = CredentialsFactory::createInstance('test_');
        $arrayCreds = $creds->toArray();

        $this->assertEquals('test_api_key', $arrayCreds['api_key']);
        $this->assertEquals('test_api_secret_key', $arrayCreds['api_secret_key']);
        $this->assertEquals('test_access_token', $arrayCreds['access_token']);
        $this->assertEquals('test_access_token_secret', $arrayCreds['access_token_secret']);
    }
}
