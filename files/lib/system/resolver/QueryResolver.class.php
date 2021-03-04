<?php

namespace graphql\system\resolver;

use graphql\util\CredentialUtil;
use wcf\data\article\Article;
use wcf\data\article\ArticleList;
use wcf\data\category\Category;
use wcf\data\category\CategoryList;
use wcf\data\language\Language;
use wcf\data\language\LanguageList;
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
            'article' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['article']);

                return new Article($args['id']);
            },
            'articles' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['article']);

                $list = new ArticleList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
            'category' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['category']);

                return new Category($args['id']);
            },
            'categories' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['category']);

                $list = new CategoryList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
            'language' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['language']);

                return new Language($args['id']);
            },
            'languages' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['language']);

                $list = new LanguageList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
            'ping' => function () {
                return 'pong';
            },
            'user' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['user']);

                return new User($args['id']);
            },
            'users' => function ($value, $args, $context) {
                CredentialUtil::hasPermissions($context, ['user']);

                $list = new UserList();
                $list->sqlOffset = $args['skip'];
                $list->sqlLimit = $args['first'];
                $list->readObjects();

                return $list->getObjects();
            },
        ]);
    }
}
