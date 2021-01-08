<?php
namespace graphql\system\resolver;

class UserResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'language' => function ($value) {
                return $value->getLanguage();
            },
        ]);
    }
}
