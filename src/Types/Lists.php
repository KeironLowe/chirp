<?php declare(strict_types=1);

namespace KeironLowe\Chirp;

use KeironLowe\Chirp\Objects\Pagination;
use KeironLowe\Chirp\Objects\UserList;
use Tightenco\Collect\Support\Collection;

class Lists extends Chirp
{


    /**
     * Returns all the lists (including their own) that the user is subscribed
     * to
     *
     * @param string|int $userIdentifier
     * @param array<mixed> $params
     * @return Collection<Mixed>|null
     */
    public function getAll($userIdentifier, array $params = [])
    {
        $lists = $this->getFromCache('all_lists');

        if (!$lists) {
            $response = $this->get('lists/list', array_merge([
                'user_id'     => is_int($userIdentifier) ? $userIdentifier : '',
                'screen_name' => is_string($userIdentifier) ? $userIdentifier : '',
            ], $params));

            if ($response->isOk()) {
                $lists = UserList::convertArray($response->json());
                $this->addToCache('all_lists', $lists);
            }
        }

        return $lists;
    }


    public function getMembersFor($listIdentifier, array $params = [])
    {
        $members = $this->getFromCache('list_members');

        if (!$members) {
            $response = $this->get('lists/members', array_merge([
                'list_id' => is_int($listIdentifier) ? $listIdentifier : '',
                'slug'    => is_string($listIdentifier) ? $listIdentifier : '',
            ], $params));

            if ($response->isOk()) {
                $members = Pagination::factory($response->json());
                $this->addToCache('members', $members);
            }
        }

        return $members;
    }
}
