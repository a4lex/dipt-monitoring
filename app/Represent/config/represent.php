<?php

return [

    /*
     * Represent model storage
     */

    'storage_type' => env('RRS_MODEL_STORAGE', 'db'),

    'storages' => [
        'db'                => App\Represent\DbRepresentStorage::class,
        'json'              => App\Represent\JsonRepresentStorage::class,
    ],

    'table' => [
        'actions'       => env('RRS_DB_COL_TYPES','actions'),
        'models'        => env('RRS_DB_MODELS', 'models'),
        'joins'         => env('RRS_DB_JOINS','joins'),
        'wheres'        => env('RRS_DB_WHERES','wheres'),
        'columns'       => env('RRS_DB_COLUMNS','columns'),
        'column_types'  => env('RRS_DB_COL_TYPES','column_types'),
        'column_options'=> env('RRS_DB_COL_OPTIONS','column_options'),
    ],
];
