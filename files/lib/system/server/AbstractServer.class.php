<?php
namespace graphql\system\server;

use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use GraphQL\Validator\DocumentValidator;
use GraphQL\Validator\Rules\QueryDepth;
use wcf\system\event\EventHandler;

abstract class AbstractServer implements IServer
{
    protected $resolvers = [];
    protected $typeConfigDecorator;

    /**
     * @var ServerConfig
     */
    protected $config;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        //set resolvers
        $this->registerResolvers([
            'Query' => \graphql\system\resolver\QueryResolver::class,
            'QueryArticle' => \graphql\system\resolver\QueryArticleResolver::class,
            'Article' => \graphql\system\resolver\ArticleResolver::class,
            'User' => \graphql\system\resolver\UserResolver::class,
        ]);

        // call registerResolvers event
        EventHandler::getInstance()->fireAction($this, 'registerResolvers');

        // get type config decorator
        $this->typeConfigDecorator = function ($typeConfig, $typeDefinitionNode) {
            if (array_key_exists($typeConfig['name'], $this->resolvers)) {
                $typeConfig['resolveField'] = new $this->resolvers[$typeConfig['name']];
            }
            return $typeConfig;
        };

        $this->setConfig();
    }

    /**
     * @inheritDoc
     */
    public function setConfig(): void
    {
        if (!isset($this->config)) {
            $this->config = ServerConfig::create();
            $this->config->setSchema($this->buildSchema());
            $this->config->setQueryBatching(true);

            return;
            $this->config->setValidationRules([
                DocumentValidator::addRule(new QueryDepth(1)),
            ]);
        }
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        try {
            $server = new StandardServer($this->config);
            $server->handleRequest();
        } catch (\Exception $e) {
            StandardServer::send500Error($e);
        }
    }

    /**
     * @inheritDoc
     */
    public function registerResolver($resolver): void
    {
        if (array_key_exists($resolver::getName(), $this->resolvers)) {
            #$this->resolvers[$resolver::getName()]->appendResolver($resolver);
        } else {
            $this->resolvers[$resolver::getName()] = $resolver;
        }
    }

    /**
     * @inheritDoc
     */
    public function registerResolvers($resolvers = []): void
    {
        foreach ($resolvers as $resolver) {
            $this->registerResolver($resolver);
        }
    }
}
