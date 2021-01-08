<?php
namespace graphql\system\resolver;

abstract class AbstractResolver implements IResolver
{
    protected $fieldResolvers = [];

    public static function getName()
    {
        $tmp = explode('\\', substr(get_called_class(), 0, -8));
        return array_pop($tmp);
    }

    /**
     * @inheritDoc
     */
    public function __invoke($value, $args, $context, $info)
    {
        if (array_key_exists($info->fieldName, $this->fieldResolvers)) {
            return $this->fieldResolvers[$info->fieldName]($value, $args, $context, $info);
        } else {
            return $value->{$info->fieldName};
        }
    }
}
