<?php declare(strict_types=1);

namespace KeironLowe\Chirp\Tests\Unit;

use Zttp\Zttp;
use KeironLowe\Chirp\OAuth;
use PHPUnit\Framework\TestCase;
use KeironLowe\Chirp\Credentials;

final class OAuthTest extends TestCase
{


    /**
     * The Twitter API credentials
     *
     * @var array<mixed>
     */
    private $creds;


    /**
     * Setup our test case
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->creds = [
            'apiKey'       => getenv('TWITTER_API_KEY'),
            'apiSecret'    => getenv('TWITTER_API_SECRET'),
            'accessToken'  => getenv('TWITTER_API_ACCESS_TOKEN'),
            'accessSecret' => getenv('TWITTER_API_ACCESS_SECRET')
        ];
    }


    /**
     * Tests that the getSignatureParameters method accepts an options array.
     *
     * @return void
     */
    public function testGetSignatureParametersAcceptsOptions(): void
    {
        $signatureParameters = $this->createSignatureParameters(['test' => true]);

        $this->assertArrayHasKey('test', $signatureParameters);
        $this->assertEquals(true, $signatureParameters['test']);
    }


    /**
     * Tests that the getSignatureParameters sorts the array parameters.
     *
     * @return void
     */
    public function testGetSignatureParametersSortsParameters(): void
    {
        $signatureParameters = $this->createSignatureParameters(['a_test' => 'a_test', 'z_test' => 'z_test']);

        $this->assertTrue($this->arrayIsSorted(($signatureParameters)));
    }


    /**
     * Tests that the generateSignatureBase returns a properly formatted string
     *
     * @return void
     */
    public function testGenerateSignatureBaseReturnsCorrectBase(): void
    {
        $parametersHash = http_build_query(['test' => true]);
        $signatureBase  = OAuth::generateSignatureBase('GET', 'statuses/show', $parametersHash);

        $this->assertEquals('GET&statuses%2Fshow&test%3D1', $signatureBase);
    }


    /**
     * Tests that the generateSignatureKey method returns a properly formatted
     * string
     *
     * @return void
     */
    public function testGenerateSignatureKeyReturnsCorrectKey(): void
    {
        $signatureKey = OAuth::generateSignatureKey($this->creds['apiSecret'], $this->creds['accessSecret']);
        $expectedKey  = rawurlencode($this->creds['apiSecret']) . '&' . rawurlencode($this->creds['accessSecret']);

        $this->assertEquals($expectedKey, $signatureKey);
    }


    /**
     * Tests that the generateAuthorizationHeader method correctly prefixes
     * the header string with 'OAuth '
     *
     * @return void
     */
    public function testGenerateAuthorizationHeaderHasOAuthPrefix(): void
    {
        $credentials = new Credentials($this->creds);
        $signature   = OAuth::generateAuthorizationHeader('GET', 'statuses/show', [], $credentials);
        $this->assertStringStartsWith('Oauth ', $signature);
    }


    /**
     * Tests that the authorization header works.
     *
     * @return void
     */
    public function testAuthorizationHeaderWorks(): void
    {
        $endpoint    = 'https://api.twitter.com/1.1/account/settings.json';
        $credentials = new Credentials($this->creds);
        $response    = Zttp::withHeaders([
            'Authorization' => OAuth::generateAuthorizationHeader('GET', $endpoint, [], $credentials)
        ])->get($endpoint);
    
        $this->assertTrue($response->isOk());
    }


    /**
     * Helper method to return signature parameters.
     *
     * @param array<mixed> $options
     * @return array<mixed>
     */
    private function createSignatureParameters(array $options = []): array
    {
        return OAuth::getSignatureParameters($this->creds['apiKey'], $this->creds['accessToken'], $options);
    }


    /**
     * Returns true if the array has already been ksorted.
     *
     * @param array<mixed> $array
     * @return boolean
     */
    private function arrayIsSorted(array $array): bool
    {
        $a = $array;
        $b = $array;
        ksort($b);

        return $a === $b;
    }
}
