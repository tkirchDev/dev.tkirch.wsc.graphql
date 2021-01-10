<?php
namespace graphql\data\credential\token;

use graphql\data\credential\Credential;
use wcf\data\DatabaseObject;

class CredentialToken extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'credentialTokenID';

    /**
     * store credential object
     *
     * @var Credential
     */
    protected $credential;

    /**
     * get credential from token
     *
     * @return Credential
     */
    public function getCredential(): Credential
    {
        if (empty($this->credential)) {
            $credential = new Credential($this->credentialID);
            if ($credential->credentialID) {
                $this->credential = $credential;
            }
        }

        return $this->credential;
    }
}
