<?php
namespace graphql\system\resolver;

abstract class AbstractResolver implements IResolver
{
    protected static $name;
    protected $fieldResolvers = [];

    public static function getName()
    {
        if (!empty(static::$name)) {
            return ucfirst(static::$name);
        } else {
            $tmp = explode('\\', substr(get_called_class(), 0, -8));
            return array_pop($tmp);
        }
    }

    public function getFieldResolvers()
    {
        return $this->fieldResolvers;
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

    public function appendResolver($resolver): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, (new $resolver)->getFieldResolvers());
    }
}
