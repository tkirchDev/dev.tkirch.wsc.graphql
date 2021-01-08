<?php
namespace graphql\system\resolver;

class ArticleResolver extends AbstractResolver
{

    public function __construct()
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'title' => function ($value) {
                return $value->getTitle();
            },
            'teaser' => function ($value) {
                return $value->getTeaser();
            },
            // 'user' => function ($value) {
            //     return new User($value->getUserID());
            // },
        ]);
    }
}
