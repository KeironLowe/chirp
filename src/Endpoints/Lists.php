<?php declare(strict_types=1);

namespace Chirp\Endpoints;

use Chirp\Chirp;
use Chirp\Objects\Tweet;
use Chirp\Response;

class Lists extends Chirp
{
    // public function allList()
    // {
    //     // lists/list
    // }

    // public function list()
    // {
    //     // lists/show
    // }

    // public function isMemberOf()
    // {
    //     // lists/members/show
    // }

    // public function isSubscribedTo()
    // {
    //     // lists/subscribers/show
    // }

    // public function membersOf()
    // {
    //     // lists/members
    // }


    /**
     * Returns the tweets for a particular list.
     *
     * @param int|string $identifier
     * @param array<mixed> $params
     * @return Response
     */
    public function tweetsFor($identifier, array $params = []): Response
    {
        $identifier = $this->getId($identifier);
        $parameters = array_merge($identifier, $params);

        // Get the response, and map the data appropriately.
        $response = $this->get('lists/statuses', $parameters);
        $response->map(Tweet::class);

        return $response;
    }

    // public function subscribersFor()
    // {
    //     // lists/subscribers
    // }

    // public function usersMemberships()
    // {
    //     // lists/memberships
    // }

    // public function usersLists()
    // {
    //     // lists/ownerships
    // }

    // public function usersSubscriptions()
    // {
    //     // lists/subscriptions
    // }


    /**
     * Returns an array with the correct identifier for an API call.
     *
     * @param string|int $identifier
     * @return array<string, mixed>
     */
    private function getId($identifier): array
    {
        $param = [];

        if (is_string($identifier)) {
            $param['slug'] = $identifier;
        }

        if (is_int($identifier)) {
            $param['list_id'] = $identifier;
        }

        return $param;
    }
}
