<?php
namespace graphql\system\resolver;

use wcf\data\article\Article;
use wcf\data\article\ArticleList;

class QueryResolver extends AbstractResolver
{

    public function __construct()
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
        ]);
    }
}
