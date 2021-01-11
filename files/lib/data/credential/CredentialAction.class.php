<?php
namespace graphql\data\credential;

use wcf\data\AbstractDatabaseObjectAction;

class CredentialAction extends AbstractDatabaseObjectAction
{

    /**
     * @inheritDoc
     */
    protected $permissionsCreate = ['admin.graphql.canManageCredential'];

    /**
     * @inheritDoc
     */
    protected $permissionsDelete = ['admin.graphql.canManageCredential'];

    /**
     * @inheritDoc
     */
    protected $permissionsUpdate = ['admin.graphql.canManageCredential'];

}
