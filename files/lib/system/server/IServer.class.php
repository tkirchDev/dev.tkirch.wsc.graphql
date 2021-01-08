<?php
namespace graphql\system\server;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';

use GraphQL\Type\Schema;

interface IServer
{
    public function __construct();
    public function setConfig(): void;
    public function execute(): void;
    public function buildSchema(): Schema;
}
