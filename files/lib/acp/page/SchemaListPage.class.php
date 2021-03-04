<?php

namespace graphql\acp\page;

use graphql\data\schema\SchemaList;
use wcf\page\SortablePage;

class SchemaListPage extends SortablePage
{

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'graphql.acp.menu.link.schema.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.graphql.canManageSchema'];

    /**
     * @inheritDoc
     */
    public $objectListClassName = SchemaList::class;

    /**
     * @inheritDoc
     */
    public $defaultSortField = 'priority';

    /**
     * @inheritDoc
     */
    public $validSortFields = ['name', 'priority'];
}
