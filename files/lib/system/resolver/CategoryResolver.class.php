<?php
namespace graphql\system\resolver;

class CategoryResolver extends AbstractResolver
{

    /**
     * @inheritDoc
     */
    public function setFieldResolvers(): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, [
            'parent' => function ($value) {
                return $value->getParentCategory();
            },
        ]);
    }
}
