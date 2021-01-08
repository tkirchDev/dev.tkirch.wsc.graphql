<?php
namespace graphql\page;

use GraphQL\GraphQL;
use graphql\system\server\DefaultServer;
use wcf\page\AbstractPage;

class IndexPage extends AbstractPage
{
    /**
     * @inheritDoc
     */
    public function show()
    {
        $server = new DefaultServer();
        $server->execute();
    }
}
