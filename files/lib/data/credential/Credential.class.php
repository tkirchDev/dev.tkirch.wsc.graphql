<?php
namespace graphql\data\credential;

use graphql\data\credential\token\CredentialTokenList;
use wcf\data\DatabaseObject;
use wcf\system\request\IRouteController;

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
}
