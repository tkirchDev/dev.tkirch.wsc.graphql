<?php
namespace graphql\system\resolver;

use graphql\util\CredentialUtil;

class MutationResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'generateToken' => function ($value, $args) {
                return CredentialUtil::generateToken($args['key'] ?? '', $args['secret'] ?? '', $args['type'] ?? '');
            },
        ]);
    }
}
