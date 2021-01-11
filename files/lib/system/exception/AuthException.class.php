<?php
namespace graphql\system\exception;

use GraphQL\Error\ClientAware;

class AuthException extends \Exception implements ClientAware
{
    /**
     * @inheritDoc
     */
    public function isClientSafe()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getCategory()
    {
        return 'auth';
    }
}
