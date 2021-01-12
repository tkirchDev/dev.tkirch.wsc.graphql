<?php
namespace graphql\data\permission;

use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;
use wcf\system\WCF;

class Permission extends DatabaseObject implements IRouteController
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'permissionID';

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
        return WCF::getLanguage()->get('graphql.permission.name.' . $this->name);
    }
}
