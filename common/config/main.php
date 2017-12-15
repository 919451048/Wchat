<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'redis' => [  
        'class' => 'yii\redis\Connection',  
        'hostname' => '192.168.43.120',  
        'port' => 6379,  
        'database' => 0,  
        ],   
     
    ],
   
];
