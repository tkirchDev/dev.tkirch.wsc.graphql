<?php
namespace graphql\data\permission;

use wcf\data\DatabaseObjectList;

class PermissionList extends DatabaseObjectList
{
    /**
     * @inheritDoc
     */
    public $sqlOrderBy = 'name';
}
