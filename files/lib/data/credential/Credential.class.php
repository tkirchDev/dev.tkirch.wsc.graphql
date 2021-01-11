<?php
namespace graphql\data\credential;

use graphql\data\credential\token\CredentialTokenList;
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
