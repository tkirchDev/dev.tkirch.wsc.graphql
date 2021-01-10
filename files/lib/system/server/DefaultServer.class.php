<?php
namespace graphql\system\server;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';
use graphql\data\schema\SchemaList;
use GraphQL\Type\Schema;
use graphql\util\CredentialUtil;
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
        //check for authorization
        if (isset(apache_request_headers()['Authorization'])) {
            $token = CredentialUtil::checkToken(apache_request_headers()['Authorization']);
        }

        $schema = BuildSchema::build('
            schema {
                query: Query
                mutation: Mutation
            }
            type Query
            type Mutation
        ');

        //get schema files and extend schema
        $schemaList = new SchemaList();
        $schemaList->readObjects();

        foreach ($schemaList as $schemaFile) {
            $schema = SchemaExtender::extend($schema, $schemaFile->getParsedFileContent());
        }
        $schema = BuildSchema::build(SchemaPrinter::doPrint($schema), $this->typeConfigDecorator);

        return $schema;
    }
}
