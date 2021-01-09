<?php
namespace graphql\system\server;

use graphql\data\schema\SchemaList;
use GraphQL\Language\Parser;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\SchemaExtender;
use GraphQL\Utils\SchemaPrinter;

class DefaultServer extends AbstractServer
{
    /**
     * @inheritDoc
     */
    public function buildSchema(): Schema
    {
        $schema = BuildSchema::build('
            schema {
                query: Query
            }
            type Query');

        //get schema files and extend schema
        $schemaList = new SchemaList();
        $schemaList->readObjects();

        foreach ($schemaList as $schemaFile) {
            if (file_exists(WCF_DIR . $schemaFile->filepath)) {
                $fileContent = file_get_contents(WCF_DIR . $schemaFile->filepath);
                $documentNode = Parser::parse($fileContent);
                $schema = SchemaExtender::extend($schema, $documentNode);
            }
        }
        $schema = BuildSchema::build(SchemaPrinter::doPrint($schema), $this->typeConfigDecorator);

        return $schema;
    }
}
