<?php
namespace graphql\system\resolver;

use wcf\data\article\Article;
use wcf\data\article\ArticleList;
use wcf\data\language\Language;
use wcf\data\user\User;
use wcf\data\user\UserList;

class QueryResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'article' => function ($value, $args) {
                return new Article($args['id']);
            },
            'articles' => function ($value, $args) {
                $list = new ArticleList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
            'language' => function ($value, $args) {
                return new Language($args['id']);
            },
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
