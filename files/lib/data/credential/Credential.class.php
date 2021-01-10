<?php
namespace graphql\data\credential;

use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;

class Credential extends DatabaseObject implements IRouteController
{
    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->name;
    }
}
