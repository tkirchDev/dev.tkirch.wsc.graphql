<?php
namespace graphql\system\resolver;

use wcf\data\user\User;

class ArticleResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'user' => function ($value) {
                return new User($value->getUserID());
            },
            'teaser' => function ($value) {
                return $value->getTeaser();
            },
            'title' => function ($value) {
                return $value->getTitle();
            },
        ]);
    }
}
