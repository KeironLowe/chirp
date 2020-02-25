<?php
namespace KeironLowe\Chirp;

use Carbon\Carbon;

class Tweet
{


    /**
     * The raw data for the Tweet.
     *
     * @var array<mixed>
     */
    private $data;


    /**
     * Creates a new instance of Tweet.
     *
     * @param array<mixed> $tweet
     */
    public function __construct(array $tweet)
    {
        $this->data = $tweet;
    }


    /**
     * Returns the created date.
     *
     * @return Carbon
     */
    public function createdDate(): Carbon
    {
        return Carbon::parse($this->data['created_at']);
    }


    /**
     * Returns the tweet ID
     *
     * @return integer
     */
    public function id(): int
    {
        return $this->data['id'];
    }


    /**
     * Returns the Tweet text.
     *
     * @return string
     */
    public function text(): string
    {
        return $this->data['full_text'];
    }


    /**
     * Returns true if the text has been truncated.
     *
     * @return bool
     */
    public function isTruncated(): bool
    {
        return $this->data['truncated'];
    }


    /**
     * Returns the text range array.
     *
     * @return array<int>
     */
    public function textRange(): array
    {
        return $this->data['display_text_range'];
    }
}
