<?php
/**
 * Created by PhpStorm.
 * User: komal
 * Date: 16/07/2017
 * Time: 5:43 PM
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [
        /* temporary: uploaded and waiting for complete register */
        'temp_profile' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/temp/profile'),
        ],
        'temp_id_card' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/temp/id_card'),
        ],
        'temp_house_registration' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/temp/house_registration'),
        ],
        'temp_license' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/temp/license'),
        ],
        'temp_bookbank' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/temp/bookbank'),
        ],

        /* registered: registered completely */
        'registered_profile' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/registered/profile'),
        ],
        'registered_id_card' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/registered/id_card'),
        ],
        'registered_house_registration' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/registered/house_registration'),
        ],
        'registered_license' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/registered/license'),
        ],
        'registered_bookbank' => [
            'driver' => 'local',
            'root' => storage_path('filedrop/registered/bookbank'),
        ],
        
        /* default */
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],

];