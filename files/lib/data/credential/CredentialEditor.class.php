<?php

namespace graphql\data\credential;

use wcf\data\DatabaseObjectEditor;
use wcf\util\PasswordUtil;

class CredentialEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = Credential::class;

    /**
     * @inheritDoc
     * @return    Credential
     */
    public static function create(array $parameters = [])
    {
        //create salt and secret hash
        if ($parameters['secret'] !== '') {
            if ($parameters['secret'] !== null) {
                $parameters['secret'] = PasswordUtil::getDoubleSaltedHash($parameters['secret']);
            } else {
                $parameters['secret'] = 'invalid:';
            }
        }

        return parent::create($parameters);
    }

    /**
     * @inheritDoc
     */
    public function update(array $parameters = [])
    {
        // update salt and create new secret hash
        if (array_key_exists('password', $parameters) && $parameters['password'] !== '') {
            if ($parameters['password'] === null) {
                $parameters['password'] = 'invalid:';
            } else {
                $parameters['password'] = PasswordUtil::getDoubleSaltedHash($parameters['password']);
            }
        } else {
            unset($parameters['password']);
        }

        parent::update($parameters);
    }
}
