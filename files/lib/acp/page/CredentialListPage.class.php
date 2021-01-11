<?php
namespace graphql\acp\page;

use graphql\data\credential\CredentialList;
use wcf\page\SortablePage;

class CredentialListPage extends SortablePage
{

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'graphql.acp.menu.link.credential.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.graphql.canManageCredential'];

    /**
     * @inheritDoc
     */
    public $objectListClassName = CredentialList::class;

    /**
     * @inheritDoc
     */
    public $defaultSortField = 'credentialID';

    /**
     * @inheritDoc
     */
    public $validSortFields = ['credentialID', 'name'];
}
