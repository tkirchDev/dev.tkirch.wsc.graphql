<?php
namespace graphql\system\resolver;

use wcf\system\event\EventHandler;

abstract class AbstractResolver implements IResolver
{
    /**
     * name of the resolver
     *
     * @var String
     */
    protected static $name;

    /**
     * list of field resolvers
     *
     * @var array
     */
    protected $fieldResolvers = [];

    /**
     * @inheritDoc
     */
    public static function getName(): String
    {
        if (!empty(static::$name)) {
            return ucfirst(static::$name);
        } else {
            $tmp = explode('\\', substr(get_called_class(), 0, -8));
            return array_pop($tmp);
        }
    }

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        // call beforeSetFieldResolvers event
        EventHandler::getInstance()->fireAction($this, 'beforeSetFieldResolvers');

        $this->setFieldResolvers();

        // call afterSetFieldResolvers event
        EventHandler::getInstance()->fireAction($this, 'afterSetFieldResolvers');
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

    /**
     * @inheritDoc
     */
    public function appendFieldResolvers($fieldResolvers = []): void
    {
        $this->fieldResolvers = array_merge($this->fieldResolvers, $fieldResolvers);
    }

    /**
     * @inheritDoc
     */
    public function getFieldResolvers(): array
    {
        return $this->fieldResolvers;
    }
}
