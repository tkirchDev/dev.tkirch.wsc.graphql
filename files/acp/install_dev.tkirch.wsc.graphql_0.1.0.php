<?php
use graphql\data\schema\SchemaAction;
use wcf\system\database\table\column\NotNullInt10DatabaseTableColumn;
use wcf\system\database\table\column\NotNullVarchar255DatabaseTableColumn;
use wcf\system\database\table\column\ObjectIdDatabaseTableColumn;
use wcf\system\database\table\column\TextDatabaseTableColumn;
use wcf\system\database\table\DatabaseTable;
use wcf\system\database\table\DatabaseTableChangeProcessor;
use wcf\system\WCF;

$tables = [
    DatabaseTable::create('graphql1_schema')
        ->columns([
            ObjectIdDatabaseTableColumn::create('schemaID'),
            NotNullVarchar255DatabaseTableColumn::create('name'),
            TextDatabaseTableColumn::create('filepath'),
            NotNullInt10DatabaseTableColumn::create('priority')
                ->defaultValue(1000),
        ]),
];

(new DatabaseTableChangeProcessor(
    $this->installation->getPackage(),
    $tables,
    WCF::getDB()->getEditor())
)->process();

// add default schemas
(new SchemaAction([], 'create', [
    'data' => [
        'name' => 'QuerySchema',
        'filepath' => 'graphql/lib/system/schema/query.graphql',
        'priority' => -1000,
    ],
]))->executeAction();
