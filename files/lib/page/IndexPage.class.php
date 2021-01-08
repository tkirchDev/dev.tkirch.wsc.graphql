<?php
namespace graphql\page;

use GraphQL\GraphQL;
use GraphQL\Language\Parser;
use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use graphql\system\server\DefaultServer;
use GraphQL\Utils\BuildSchema;
use GraphQL\Utils\SchemaExtender;
use wcf\page\AbstractPage;

class IndexPage extends AbstractPage
{
    /**
     * @inheritDoc
     */
    public function show()
    {

        $server = new DefaultServer();

        $server->execute();
        exit();

        // get type config decorator
        $typeConfigDecorator = function ($typeConfig, $typeDefinitionNode) {
            if (class_exists('\graphql\system\resolver\\' . $typeConfig['name'] . 'Resolver')) {
                $resolverClass = '\graphql\system\resolver\\' . $typeConfig['name'] . 'Resolver';
                $typeConfig['resolveField'] = new $resolverClass;
            }
            return $typeConfig;
        };

        // build schema
        $schema = BuildSchema::build('
            schema {
                query: Query
            }
            type Query', $typeConfigDecorator);

        //get schema files and extend schema
        $files = glob(WCF_DIR . 'graphql/lib/system/schema/*.graphql');
        natsort($files);
        foreach (array_map('file_get_contents', $files) as $fileContent) {
            $documentNode = Parser::parse($fileContent);
            $schema = SchemaExtender::extend($schema, $documentNode);
        }

        try {
            //server configuration
            $config = ServerConfig::create();
            $config->setSchema($schema);
            $config->setQueryBatching(true);

            // create server
            $server = new StandardServer($config);

            // handle request
            $server->handleRequest();
        } catch (\Exception $e) {
            StandardServer::send500Error($e);
        }
    }
}
