<?php declare(strict_types=1);

namespace KeironLowe\Chirp\Objects;

use Tightenco\Collect\Support\Collection;

class UserList extends BaseObject
{


    /**
     * Creates a new instance of BaseObject
     *
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->user = new User($this->data['user']);
    }


    /**
     * Converts an array of items into a collection of UserLists
     *
     * @param array<mixed> $data
     * @return Collection<mixed>
     */
    public static function convertArray(array $data): Collection
    {
        return collect($data)->map(function ($list) {
            return new self($list);
        });
    }
}
