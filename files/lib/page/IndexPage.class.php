<?php
namespace graphql\page;

require_once WCF_DIR . 'lib/system/api/graphql-php/autoload.php';
use GraphQL\GraphQL;
use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Utils\BuildSchema;
use wcf\data\article\Article;
use wcf\data\article\ArticleList;
use wcf\data\option\Option;
use wcf\data\option\OptionList;
use wcf\data\user\User;
use wcf\page\AbstractPage;

class IndexPage extends AbstractPage
{
    /**
     * @inheritDoc
     */
    public function show()
    {
        $contents = file_get_contents(WCF_DIR . 'graphql/lib/system/graphql/schema/schema.graphql');

        $typeConfigDecorator = function ($typeConfig, $typeDefinitionNode) {
            switch ($typeConfig['name']) {
                case 'Query':
                    $typeConfig['resolveField'] = function ($value, $args, $context, $info) {
                        switch ($info->fieldName) {

                            case 'option':
                                return new Option($args['id']);
                                break;

                            case 'options':
                                $list = new OptionList();
                                $list->sqlOffset = $args['skip'];
                                $list->sqlLimit = $args['first'];
                                $list->readObjects();

                                return $list->getObjects();

                                break;
                            case 'article':
                                return new Article($args['id']);
                                break;

                            case 'articles':
                                $list = new ArticleList();
                                $list->sqlOffset = $args['skip'];
                                $list->sqlLimit = $args['first'];
                                $list->readObjects();

                                return $list->getObjects();

                                break;
                        }

                    };
                    break;
                case 'Article':
                    $typeConfig['resolveField'] = function ($value, $args, $context, $info) {
                        switch ($info->fieldName) {
                            case 'title':
                                return $value->getTitle();
                                break;
                            case 'teaser':
                                return $value->getTeaser();
                                break;
                            case 'user':
                                return new User($value->getUserID());
                                break;
                            default:
                                return $value->{$info->fieldName};
                                break;
                        }
                    };
                    break;
            }
            return $typeConfig;

        };
        $schema = BuildSchema::build($contents, $typeConfigDecorator);

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
