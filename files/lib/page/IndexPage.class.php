<?php
namespace graphql\page;

use GraphQL\GraphQL;
use graphql\system\server\DefaultServer;
use wcf\page\AbstractPage;

class IndexPage extends AbstractPage
{
    /**
     * server object
     *
     * @var IServer
     */
    protected $server;

    /**
     * @inheritDoc
     */
    public function __run()
    {
        $this->server = new DefaultServer();
        parent::__run();
    }

    /**
     * @inheritDoc
     */
    public function readParameters()
    {
        parent::readParameters();
        $this->server->authenticate();
    }

    /**
     * @inheritDoc
     */
    public function show()
    {
        $this->server->execute();
    }
}
