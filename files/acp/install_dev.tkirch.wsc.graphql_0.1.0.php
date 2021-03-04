<?php

use graphql\data\permission\PermissionAction;
use graphql\data\schema\SchemaAction;
use wcf\system\database\table\column\NotNullInt10DatabaseTableColumn;
use wcf\system\database\table\column\NotNullVarchar255DatabaseTableColumn;
use wcf\system\database\table\column\ObjectIdDatabaseTableColumn;
use wcf\system\database\table\column\TextDatabaseTableColumn;
use wcf\system\database\table\DatabaseTable;
use wcf\system\database\table\DatabaseTableChangeProcessor;
use wcf\system\database\table\index\DatabaseTableForeignKey;
use wcf\system\database\table\index\DatabaseTableIndex;
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
            NotNullVarchar255DatabaseTableColumn::create('credentialKey'),
            TextDatabaseTableColumn::create('secret'),
        ])
        ->indices([
            DatabaseTableIndex::create()
                ->type(DatabaseTableIndex::UNIQUE_TYPE)
                ->columns(['credentialKey']),
        ]),
    DatabaseTable::create('graphql1_permission')
        ->columns([
            ObjectIdDatabaseTableColumn::create('permissionID'),
            NotNullVarchar255DatabaseTableColumn::create('name'),
        ]),
    DatabaseTable::create('graphql1_credential_token')
        ->columns([
            ObjectIdDatabaseTableColumn::create('credentialTokenID'),
            NotNullInt10DatabaseTableColumn::create('credentialID'),
            NotNullVarchar255DatabaseTableColumn::create('type'),
            NotNullInt10DatabaseTableColumn::create('validUntil'),
            NotNullInt10DatabaseTableColumn::create('createdAt'),
        ])
        ->foreignKeys([
            DatabaseTableForeignKey::create()
                ->columns(['credentialID'])
                ->referencedTable('graphql1_credential')
                ->referencedColumns(['credentialID'])
                ->onDelete('CASCADE'),
        ]),
    DatabaseTable::create('graphql1_credential_permission')
        ->columns([
            NotNullInt10DatabaseTableColumn::create('credentialID'),
            NotNullInt10DatabaseTableColumn::create('permissionID'),
        ])
        ->foreignKeys([
            DatabaseTableForeignKey::create()
                ->columns(['credentialID'])
                ->referencedTable('graphql1_credential')
                ->referencedColumns(['credentialID'])
                ->onDelete('CASCADE'),
            DatabaseTableForeignKey::create()
                ->columns(['permissionID'])
                ->referencedTable('graphql1_permission')
                ->referencedColumns(['permissionID'])
                ->onDelete('CASCADE'),
        ])
        ->indices([
            DatabaseTableIndex::create()
                ->type(DatabaseTableIndex::UNIQUE_TYPE)
                ->columns(['credentialID', 'permissionID']),
        ]),
];

(new DatabaseTableChangeProcessor(
    $this->installation->getPackage(),
    $tables,
    WCF::getDB()->getEditor()
))->process();

// add default schemas
(new SchemaAction([], 'create', [
    'data' => [
        'name' => 'QuerySchema',
        'filepath' => 'graphql/lib/system/schema/query.graphql',
        'priority' => -1000,
    ],
]))->executeAction();

// add default permissions
(new PermissionAction([], 'create', [
    'data' => [
        'name' => 'article',
    ],
]))->executeAction();

(new PermissionAction([], 'create', [
    'data' => [
        'name' => 'category',
    ],
]))->executeAction();

(new PermissionAction([], 'create', [
    'data' => [
        'name' => 'language',
    ],
]))->executeAction();

(new PermissionAction([], 'create', [
    'data' => [
        'name' => 'user',
    ],
]))->executeAction();
