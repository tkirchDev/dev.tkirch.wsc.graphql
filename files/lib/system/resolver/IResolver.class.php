<?php

namespace graphql\system\resolver;

interface IResolver
{
    /**
     * return the name of the resolver
     *
     * @return String
     */
    public static function getName(): string;

    /**
     * invoke function for graphql resolver
     *
     * @param mixed $value
     * @param mixed $args
     * @param mixed $context
     * @param mixed $info
     *
     * @return [type]
     */
    public function __invoke($value, $args, $context, $info);

    /**
     * append field resolvers to field resolvers array
     *
     * @param array $fieldResolvers
     *
     * @return void
     */
    public function appendFieldResolvers($fieldResolvers = []): void;

    /**
     * return all field resolvers
     *
     * @return array
     */
    public function getFieldResolvers(): array;

    /**
     * set the field resolvers
     *
     * @return void
     */
    public function setFieldResolvers(): void;
}
