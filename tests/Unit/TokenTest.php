<?php declare(strict_types=1);

namespace Chirp\Tests;

use Chirp\Token;
use Chirp\Request;
use Chirp\Credentials;
use PHPUnit\Framework\TestCase;
use Chirp\Tests\Factories\CredentialsFactory;

final class TokenTest extends TestCase
{


    /**
     * @var Credentials
     */
    protected $creds;


    /**
     * Set's up some data for our tests.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->creds = CredentialsFactory::createInstance();
    }


    /**
     * Tests that the returned header starts with an 'Oauth' prefix.
     *
     * @return void
     */
    public function testHeaderHasOauthPrefix(): void
    {
        $token = Token::create('GET', '', $this->creds);
        $this->assertStringStartsWith('Oauth ', $token);
    }


    /**
     * Tests that token generation accepts request parameters.
     *
     * @return void
     */
    public function testTokenAcceptsRequestParameters(): void
    {
        $token = Token::create('GET', '', $this->creds, ['test_parameter' => true]);
        $this->assertStringContainsString('test_parameter', $token);
    }


    /**
     * Tests that the token contains the required parameters.
     *
     * @return void
     */
    public function testTokenContainsRequiredParameters(): void
    {
        $token = Token::create('GET', '', $this->creds);
        $this->assertStringContainsString('oauth_token', $token);
        $this->assertStringContainsString('oauth_consumer_key', $token);
        $this->assertStringContainsString('oauth_nonce', $token);
        $this->assertStringContainsString('oauth_timestamp', $token);
        $this->assertStringContainsString('oauth_version', $token);
        $this->assertStringContainsString('oauth_signature_method', $token);
        $this->assertStringContainsString('oauth_signature', $token);
    }
}
