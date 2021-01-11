<?php
namespace graphql\system\server;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';

use GraphQL\Type\Schema;

interface IServer
{
    public function __construct();
    public function authenticate(): void;
    public function buildSchema(): Schema;
    public function execute(): void;
    public function registerResolver($resolver): void;
    public function registerResolvers($resolvers = []): void;
    public function setConfig(): void;
}
