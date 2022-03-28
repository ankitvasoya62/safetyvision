<?php

$main = array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Online safetyvision',
    'timeZone' => 'Europe/Oslo',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.modules.screen.models.*',
        'application.modules.rbms.models.*',
        'application.components.*',
        'application.extensions.image.*',
       
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'rbms' => array(
            'class' => 'application.modules.rbms.RbmsModule',
            'defaultController' => 'user',
        ),
        'screen' => array(
            'class' => 'application.modules.screen.ScreenModule',
            'defaultController' => 'screen',
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
$mine = require(dirname(__FILE__) . '/' . DEVELOP_MODE . '.php');
return array_merge($main, $mine);
