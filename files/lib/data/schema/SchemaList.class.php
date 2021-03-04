<?php

namespace graphql\data\schema;

use wcf\data\DatabaseObjectList;

class SchemaList extends DatabaseObjectList
{
    /**
     * @inheritDoc
     */
    public $sqlOrderBy = 'priority';

    /**
     * @inheritDoc
     */
    public $sqlSelects = '*';

    /**
     * @inheritDoc
     */
    public $useQualifiedShorthand = false;
}
