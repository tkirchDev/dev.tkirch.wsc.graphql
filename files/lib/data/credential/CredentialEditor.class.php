<?php
namespace graphql\data\credential;

use wcf\data\DatabaseObjectEditor;

class CredentialEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = Credential::class;
}
