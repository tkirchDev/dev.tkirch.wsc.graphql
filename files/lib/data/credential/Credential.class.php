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

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        //set key as alias for credentialKey
        if ($name == 'key') {
            return $this->data['credentialKey'];
        }

        return parent::__get($name);
    }
}
