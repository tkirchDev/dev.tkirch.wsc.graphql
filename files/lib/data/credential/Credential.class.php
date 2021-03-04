<?php

namespace graphql\data\credential;

use graphql\data\credential\permission\CredentialPermissionList;
use graphql\data\credential\token\CredentialTokenList;
use graphql\data\permission\PermissionList;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;
use wcf\system\WCF;
use wcf\util\PasswordUtil;

class Credential extends DatabaseObject implements IRouteController
{
    /**
     * store tokens
     *
     * @var array
     */
    protected $tokens = [];

    /**
     * store permissions
     *
     * @var array
     */
    protected $permissions = [];

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
    public function __get($name)
    {
        //set key as alias for credentialKey
        if ($name == 'key') {
            return $this->data['credentialKey'];
        }

        return parent::__get($name);
    }

    /**
     * get all tokens from credential
     *
     * @return array
     */
    public function getTokens(): array
    {
        if (empty($this->tokens)) {
            $tokenList = new CredentialTokenList();
            $tokenList->getConditionBuilder()->add('credentialID = ?', [$this->credentialID]);
            $tokenList->readObjects();
            $this->tokens = $tokenList->getObjects();
        }

        return $this->tokens;
    }

    /**
     * returns true if the given secret is the correct secret for this credential.
     *
     * @param    string        $secret
     * @return    boolean
     */
    public function checkSecret($secret)
    {
        $isValid = false;
        $rebuild = false;

        // check if secret is a valid bcrypt hash
        if (PasswordUtil::isDifferentBlowfish($this->secret)) {
            $rebuild = true;
        }

        // secret is correct
        if (\hash_equals($this->secret, PasswordUtil::getDoubleSaltedHash($secret, $this->secret))) {
            $isValid = true;
        }

        // create new secret hash, either different encryption or different blowfish cost factor
        if ($rebuild && $isValid) {
            $userEditor = new CredentialEditor($this);
            $userEditor->update([
                'secret' => $secret,
            ]);
        }

        return $isValid;
    }

    /**
     * get all permissions from credential
     *
     * @return array
     */
    public function getPermissions(): array
    {
        if (empty($this->permissions)) {
            $credentialPermissionList = new CredentialPermissionList();
            $credentialPermissionList->getConditionBuilder()->add('credentialID = ?', [$this->credentialID]);
            $credentialPermissionList->readObjects();

            $permissionList = new PermissionList();
            $permissionList->getConditionBuilder()->add('permissionID IN (?)', [array_column($credentialPermissionList->getObjects(), 'permissionID')]);
            $permissionList->readObjects();
            $this->permissions = array_column($permissionList->getObjects(), 'name');
        }

        return $this->permissions;
    }

    /**
     * return true if object has the given permission otherwise false
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        if (in_array($permission, $this->getPermissions())) {
            return true;
        }

        return false;
    }

    /**
     * return true if object has all permissions otherwise false
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function hasPermissions(array $permissions = []): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * returns the credential with the given key.
     *
     * @param    string        $key
     * @return    Credential
     */
    public static function getByKey($key)
    {
        $sql = "SELECT * FROM " . static::getDatabaseTableName() . " WHERE credentialKey = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$key]);
        $row = $statement->fetchArray();
        if (!$row) {
            $row = [];
        }

        return new Credential(null, $row);
    }
}
