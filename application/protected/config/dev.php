<?php

return array(
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
           'urlSuffix'=>'.html',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=safetyvision',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '!2wsxcder#ere',
            'charset' => 'utf8',
            'tablePrefix' => 'sv_'
        ),
        'memcache' => array(
            'class' => 'system.caching.CMemCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ),
            ),
        ),
         'ffmpeg' => ['class' => 'system.base.Ffmpeg'],  
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
);
