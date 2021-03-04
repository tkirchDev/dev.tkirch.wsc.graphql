<?php
namespace graphql\system\resolver;

use wcf\data\category\Category;
use wcf\data\user\User;

class ArticleResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'category' => function ($value) {
                return ($value->categoryID != 0 ? new Category($value->categoryID) : null);
            },
            'teaser' => function ($value) {
                return $value->getTeaser();
            },
            'title' => function ($value) {
                return $value->getTitle();
            },
            'user' => function ($value) {
                return new User($value->getUserID());
            },
        ]);
    }
}
