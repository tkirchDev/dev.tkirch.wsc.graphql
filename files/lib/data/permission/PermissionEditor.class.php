<?php
namespace graphql\data\permission;

use wcf\data\DatabaseObjectEditor;

class PermissionEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = Permission::class;
}
