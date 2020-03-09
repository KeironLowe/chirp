<?php declare(strict_types=1);

namespace Chirp;

class Chirp
{
    public function __construct($credentials)
    {
        $this->credentials = Credentials::factory($credentials);
    }
}
