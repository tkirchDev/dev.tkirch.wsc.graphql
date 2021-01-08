<?php
namespace graphql\system\event\listener;

use wcf\system\event\listener\IParameterizedEventListener;

class TestListener implements IParameterizedEventListener
{

    public function execute($eventObj, $className, $eventName, array &$parameters)
    {
        if ($eventName == 'afterSetFieldResolvers') {

            // $eventObj->appendFieldResolvers([
            //     'article' => function ($value, $args) {
            //         return new Article($args['id']);
            //     },
            //     'articles' => function ($value, $args) {
            //         $list = new ArticleList();
            //         $list->sqlOffset = $args['skip'];
            //         $list->sqlLimit = $args['first'];
            //         $list->readObjects();

            //         return $list->getObjects();
            //     },
            // ]);
        }
    }
}
