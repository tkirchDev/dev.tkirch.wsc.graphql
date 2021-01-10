<?php
namespace graphql\data\credential\token;

use wcf\data\DatabaseObject;

class CredentialToken extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'credentialTokenID';
}
