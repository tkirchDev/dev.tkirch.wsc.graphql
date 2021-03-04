<?php

namespace graphql\acp\page;

use graphql\data\schema\Schema;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class SchemaPage extends AbstractPage
{

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'graphql.acp.menu.link.schema.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.graphql.canManageSchema'];

    /**
     * store the schema
     *
     * @var Schema
     */
    public $schema;

    /**
     * @inheritDoc
     */
    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['id'])) {
            $this->schema = new Schema(intval($_REQUEST['id']));
            if (!$this->schema->schemaID) {
                throw new IllegalLinkException();
            }
        } else {
            throw new IllegalLinkException();
        }
    }

    /**
     * @inheritDoc
     */
    public function assignVariables()
    {
        parent::assignVariables();

        // assign parameters
        WCF::getTPL()->assign([
            'schema' => $this->schema,
        ]);
    }
}
