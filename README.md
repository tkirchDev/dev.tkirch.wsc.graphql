# dev.tkirch.wsc.graphql

[![GitHub](https://img.shields.io/github/license/tkirchDev/dev.tkirch.wsc.graphql)](https://github.com/tkirchDev/dev.tkirch.wsc.graphql/LICENSE)
[![PHPCS check](https://github.com/tkirchDev/dev.tkirch.wsc.graphql/actions/workflows/codestyle.yml/badge.svg)](https://github.com/tkirchDev/dev.tkirch.wsc.graphql/actions/workflows/codestyle.yml)

Provides an extensible GraphQL schema and API for your WSC page.

## Table of contents

- [Installation](#installation)
- [Build extension yourself](#build-extension-yourself)
  - [Windows](#windows)
- [Documentation](#documentation)
  - [Send request](#send-request)
  - [Extend a resolver](#extend-a-aresolver)

## Installation

Download the latest release of this version here and install the package normally via the WSC.

## Build extension yourself

### Windows

Clone the project and execute the make.bat file. Then the package is packed so that it is ready to install.

## Documentation

### Send request

The default server is available at `http://domain.tld/graphql/`. For general information, take a look at [GraphQL](https://graphql.org).

With the following mutation you can generate a long-lived token (you create the access data for this in the acp).

```GraphQL
mutation {
    generateToken(key: "exampleKey", secret: "exampleSecret", type:"longlife") {
        value
    }
}
```

The output looks then e.g. like this:

```JSON
{
    "data": {
        "generateToken": {
            "value": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbklEIjo2LCJleHAiOjE5MjYwMDc3NjZ9.02NE6IxapsB1NY3Qf4NzC9j_baJ--Cdfc0wVH42409E"
        }
    }
}
```

To authenticate themselves to a request, they set the Authorization Header (Do not forget the `Bearer ` in front of the token.). Here is an example:

```JSON
{
    "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbklEIjo2LCJleHAiOjE5MjYwMDc3NjZ9.02NE6IxapsB1NY3Qf4NzC9j_baJ--Cdfc0wVH42409E"
}
```

### Extend a resolver

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

Create the file `graphql\system\event\listener\FooBarListener.class.php` with the content:

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
