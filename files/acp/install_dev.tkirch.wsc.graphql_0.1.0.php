<?php
use graphql\data\schema\SchemaAction;
use wcf\system\database\table\column\DatetimeDatabaseTableColumn;
use wcf\system\database\table\column\NotNullInt10DatabaseTableColumn;
use wcf\system\database\table\column\NotNullVarchar255DatabaseTableColumn;
use wcf\system\database\table\column\ObjectIdDatabaseTableColumn;
use wcf\system\database\table\column\TextDatabaseTableColumn;
use wcf\system\database\table\DatabaseTable;
use wcf\system\database\table\DatabaseTableChangeProcessor;
use wcf\system\database\table\index\DatabaseTableForeignKey;
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
    DatabaseTable::create('graphql1_credential')
        ->columns([
            ObjectIdDatabaseTableColumn::create('credentialID'),
            NotNullVarchar255DatabaseTableColumn::create('name'),
            NotNullVarchar255DatabaseTableColumn::create('key'),
            TextDatabaseTableColumn::create('secret'),
        ]),
    DatabaseTable::create('graphql1_credential_token')
        ->columns([
            ObjectIdDatabaseTableColumn::create('credentialTokenID'),
            NotNullInt10DatabaseTableColumn::create('credentialID'),
            NotNullVarchar255DatabaseTableColumn::create('type'),
            DatetimeDatabaseTableColumn::create('validUntil'),
            DatetimeDatabaseTableColumn::create('createdAt'),
        ])
        ->foreignKeys([
            DatabaseTableForeignKey::create()
                ->columns(['credentialID'])
                ->referencedTable('graphql1_credential')
                ->referencedColumns(['credentialID'])
                ->onDelete('CASCADE'),
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
