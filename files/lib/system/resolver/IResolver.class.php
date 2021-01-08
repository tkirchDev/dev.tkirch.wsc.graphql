<?php
namespace graphql\system\resolver;

interface IResolver
{
    public static function getName(): String;
    public function __invoke($value, $args, $context, $info);
    public function appendFieldResolvers($fieldResolvers = []): void;
    public function getFieldResolvers(): array;
    public function setFieldResolvers(): void;
}
