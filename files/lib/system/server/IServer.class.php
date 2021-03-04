<?php

namespace graphql\system\server;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';

use GraphQL\Type\Schema;

interface IServer
{
    /**
     * authentication function of the server
     *
     * @return void
     */
    public function authenticate(): void;

    /**
     * build the schema of the server
     *
     * @return Schema
     */
    public function buildSchema(): Schema;

    /**
     * execute the server
     *
     * @return void
     */
    public function execute(): void;

    /**
     * register a resolver
     *
     * @param mixed $resolver
     *
     * @return void
     */
    public function registerResolver($resolver): void;

    /**
     * register an array of resolvers
     *
     * @param array $resolvers
     *
     * @return void
     */
    public function registerResolvers($resolvers = []): void;

    /**
     * set config for the server
     *
     * @return void
     */
    public function setConfig(): void;
}
