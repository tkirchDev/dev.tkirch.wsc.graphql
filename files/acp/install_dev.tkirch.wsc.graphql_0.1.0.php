<?php
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
