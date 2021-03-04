<?php

namespace graphql\data\credential;

use graphql\data\credential\permission\CredentialPermissionEditor;
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

    /**
     * @inheritDoc
     */
    public function create()
    {
        $credential = parent::create();

        //check if permissions was set
        if (isset($this->parameters['permissions'])) {

            //set permissions
            foreach ($this->parameters['permissions'] as $permissionID) {
                CredentialPermissionEditor::create([
                    'permissionID' => $permissionID,
                    'credentialID' => $credential->credentialID,
                ]);
            }
        }

        return $credential;
    }
}
