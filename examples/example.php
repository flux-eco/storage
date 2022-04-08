<?php

require_once __DIR__ . '/../vendor/autoload.php';

FluxEco\DotEnv\Api::new()->load(__DIR__);

$schema = yaml_parse(file_get_contents('account.yaml'));
$tableName = $schema['title'];


//create storage
fluxStorage\createStorage($tableName, $schema, 'PROJECTION_');
//

echo "Storage created: ".PHP_EOL;
echo "Table name: ".$tableName.PHP_EOL;
echo "Schema: ".print_r($schema, true).PHP_EOL;


//append data
$data = [
    'projectionId' => '123',
    'firstname' => 'Emmett',
    'lastname' => 'Brown'
];
fluxStorage\appendData($tableName, $schema, $data, 'PROJECTION_');
//

echo "Data appended: ".print_r($data, true).PHP_EOL;


//count total rows
$totalRows = fluxStorage\countTotalRows($tableName, $schema, 'PROJECTION_', [], 0);
//

echo 'Total Rows: '.$totalRows.PHP_EOL;


//store data
$data = [
    'firstname' => 'Dr. Emmett',
];
$filter = ['projectionId' => 123];
fluxStorage\storeData($tableName, $schema, 'PROJECTION_', $filter, $data);
//

echo "Data stored: ".PHP_EOL.print_r($data, true).PHP_EOL;


//get data
$filter = ['projectionId' => 123];
$sequence = 0;
$limit = 0;
$orderBy = 'firstname';
$data = fluxStorage\getData($tableName, $schema, 'PROJECTION_', $filter, $sequence, $limit, $orderBy);
//

echo "Get data: ".PHP_EOL.print_r($data, true).PHP_EOL;


//delete data
$filter = ['projectionId' => 123];
fluxStorage\deleteData($tableName, $schema, 'PROJECTION_', $filter);
//

echo "Data deleted ".PHP_EOL;
echo "Filter ".print_r($filter, true).PHP_EOL;

//count total rows
$totalRows = fluxStorage\countTotalRows($tableName, $schema, 'PROJECTION_', [], 0);
//

echo 'Total Rows: '.$totalRows.PHP_EOL;


//delete Storage
fluxStorage\deleteStorage($tableName, $schema, 'PROJECTION_');
//

echo 'Storage deleted';