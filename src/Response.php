<?php declare(strict_types=1);

namespace Chirp;

use Zttp\ZttpResponse;
use Tightenco\Collect\Support\Collection;

class Response
{


    /**
     * @var ZttpResponse
     */
    private $data;


    /**
     * The response content
     *
     * @var mixed
     */
    private $content;


    /**
     * Creates a new instance of Response
     *
     * @param ZttpResponse $responseData
     */
    public function __construct(ZttpResponse $responseData)
    {
        $this->data = $responseData;
    }


    /**
     * Maps the response content into a collection of objects.
     *
     * @param string $object
     * @return Collection<mixed>|void
     */
    public function map(string $object)
    {

        // If the request wasn't successful, then bail.
        if (!$this->isOk()) {
            return;
        }

        // Map the array of items, into a collection of objects.
        $itemCollection = collect($this->data->json());
        $this->content  = $itemCollection->map(function ($item) use ($object) {
            return new $object($item);
        });

        return $this->content;
    }


    /**
     * Return the mapped content.
     *
     * @return mixed
     */
    public function json()
    {
        return $this->content;
    }


    /**
     * Returns true if the request was successful.
     *
     * @return boolean
     */
    public function isOk(): bool
    {
        return $this->data->isOk();
    }


    /**
     * Returns the status code from the request.
     *
     * @return integer
     */
    public function statusCode(): int
    {
        return $this->data->status();
    }


    /**
     * Returns the base response data.
     *
     * @return ZttpResponse
     */
    public function getResponseData(): ZttpResponse
    {
        return $this->data;
    }
}
