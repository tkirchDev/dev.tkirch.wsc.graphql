<?php

namespace graphql\data\credential\token;

use wcf\data\AbstractDatabaseObjectAction;

class CredentialTokenAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    public function create()
    {
        //modify created at and valid until
        $now = time();
        if (!isset($this->parameters['data']['createdAt'])) {
            $this->parameters['data']['createdAt'] = $now;
        }
        if (!isset($this->parameters['data']['validUntil'])) {

            //try to set validUntil by type
            if (isset($this->parameters['data']['type']) && in_array($this->parameters['data']['type'], ['longlife'])) {

                //check types
                if ($this->parameters['data']['type'] == 'longlife') {
                    $this->parameters['data']['validUntil'] = strtotime('+10 years', $now);
                }
            } else {
                $this->parameters['data']['validUntil'] = strtotime('+15 minutes', $now);
            }
        }

        return parent::create();
    }
}
