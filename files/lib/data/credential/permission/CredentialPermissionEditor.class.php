<?php
namespace graphql\data\credential\permission;

use wcf\data\DatabaseObjectEditor;

class CredentialPermissionEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = CredentialPermission::class;
}
