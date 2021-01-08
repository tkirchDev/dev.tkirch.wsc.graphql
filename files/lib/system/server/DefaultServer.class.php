<?php
namespace graphql\system\server;

use GraphQL\Language\Parser;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\SchemaExtender;
use GraphQL\Utils\SchemaPrinter;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

class DefaultServer extends AbstractServer
{
    public function buildSchema(): Schema
    {
        $schema = BuildSchema::build('
            schema {
                query: Query
            }
            type Query');

        //get schema files and extend schema
        $files = glob(WCF_DIR . 'graphql/lib/system/schema/*.graphql');
        natsort($files);
        foreach (array_map('file_get_contents', $files) as $fileContent) {
            $documentNode = Parser::parse($fileContent);
            $schema = SchemaExtender::extend($schema, $documentNode);
        }

        $schema = BuildSchema::build(SchemaPrinter::doPrint($schema), $this->typeConfigDecorator);

        return $schema;
    }
}
