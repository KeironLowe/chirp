<?php declare(strict_types=1);

namespace Chirp\Objects;

use Tightenco\Collect\Support\Collection;

class Tweet extends TwitterObject
{


    /**
     * The tweet data.
     *
     * @var array<mixed>
     */
    private $data;


    /**
     * Creates a new instance of Tweet.
     *
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
