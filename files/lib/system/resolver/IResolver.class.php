<?php
namespace graphql\system\resolver;

interface IResolver
{
    public function __invoke($value, $args, $context, $info);
    public static function getName();
    public function appendResolver($resolver): void;
}
