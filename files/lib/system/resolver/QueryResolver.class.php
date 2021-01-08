<?php
namespace graphql\system\resolver;

use wcf\data\user\User;
use wcf\data\user\UserList;

class QueryResolver extends AbstractResolver
{

    public function __construct()
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'user' => function ($value, $args) {
                return new User($args['id']);
            },
            'users' => function ($value, $args) {
                $list = new UserList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
        ]);
    }
}
