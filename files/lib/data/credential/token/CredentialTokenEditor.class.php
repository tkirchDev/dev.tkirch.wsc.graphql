<?php
namespace graphql\data\credential\token;

use wcf\data\DatabaseObjectEditor;

class CredentialTokenEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = CredentialToken::class;
}
