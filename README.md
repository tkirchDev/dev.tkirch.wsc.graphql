# dev.tkirch.wsc.graphql

Provides an extensible GraphQL schema and API for your WSC page.

## Extend a resolver using event listener

In the following example we extend the QueryResover with the field `foo` which returns `bar`.

Extend the `eventListener.xml` by:

```XML
<eventlistener name="fooBarListener">
    <eventclassname>graphql\system\resolver\QueryResolver</eventclassname>
    <eventname>afterSetFieldResolvers</eventname>
    <listenerclassname>graphql\system\event\listener\FooBarListener</listenerclassname>
	<inherit>1</inherit>
</eventlistener>
```

`graphql\system\event\listener\FooBarListener.class.php`

```PHP
<?php
namespace graphql\system\event\listener;

use wcf\system\event\listener\IParameterizedEventListener;

class FooBarListener implements IParameterizedEventListener
{

    public function execute($eventObj, $className, $eventName, array &$parameters)
    {
        if ($eventName == 'afterSetFieldResolvers') {
            $eventObj->appendFieldResolvers([
                'foo' => function () {
                    return 'bar';
                },
            ]);
        }
    }
}
```
