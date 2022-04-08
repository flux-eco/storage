# flux-eco/storage
This component supports the handling of mysql databases with json based table schemas.

# Usage
.env
``` 
PROJECTION_STORAGE_HOST=localhost
PROJECTION_STORAGE_DRIVER=Pdo_Mysql
PROJECTION_STORAGE_NAME=projection
PROJECTION_STORAGE_USER=user
PROJECTION_STORAGE_PASSWORD=password
```

account.yaml
``` 
title: account
type: object
properties:
  projectionId:
    type: string
  firstname:
    type: string
  lastname:
    type: string
``` 

example.php
```
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
```

output
```
Storage created: 
Table name: account
Schema: Array
(
    [title] => account
    [type] => object
    [aggregateRootNames] => Array
        (
            [0] => account
        )

    [properties] => Array
        (
            [projectionId] => Array
                (
                    [type] => string
                )

            [firstname] => Array
                (
                    [type] => string
                )

            [lastname] => Array
                (
                    [type] => string
                )

        )

)

Data appended: Array
(
    [projectionId] => 123
    [firstname] => Emmett
    [lastname] => Brown
)

Total Rows: 1
Data stored: 
Array
(
    [firstname] => Dr. Emmett
)

Get data: 
Array
(
    [0] => Array
        (
            [projectionId] => 123
            [firstname] => Dr. Emmett
            [lastname] => Brown
        )

)

Data deleted 
Filter Array
(
    [projectionId] => 123
)

Total Rows: 0
Storage deleted
```

## Contributing :purple_heart:

Please ...

1. ... register an account at https://git.fluxlabs.ch
2. ... create pull requests :fire:

## Adjustment suggestions / bug reporting :feet:

Please ...

1. ... register an account at https://git.fluxlabs.ch
2. ... ask us for a Service Level Agreement: support@fluxlabs.ch :kissing_heart:
3. ... read and create issues