<?php
namespace graphql\data\schema;

use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;

class Schema extends DatabaseObject implements IRouteController
{
    /**
     * database table for this object
     * @var    string
     */
    protected static $databaseTableName = 'schema';

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
    public static function getDatabaseTableAlias()
    {
        return null;
    }
}
