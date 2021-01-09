<?php
namespace graphql\data\schema;

use wcf\data\DatabaseObjectEditor;

class SchemaEditor extends DatabaseObjectEditor
{

    /**
     * @inheritDoc
     */
    protected static $baseClass = Schema::class;
}
