<?php
define('_WEBHOST',$_SERVER["HTTP_HOST"]);

$yii=dirname(__FILE__).'/../framework/yii.php';

if (_WEBHOST == 'wwwny.safetyvision.no') {
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    define('DEVELOP_MODE','live');
} elseif (_WEBHOST == 'dev.safetyvision.no') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    define('DEVELOP_MODE','dev');
} elseif (_WEBHOST == 'ahui.visionsafety.com') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    define('DEVELOP_MODE','huilee');
}elseif (_WEBHOST == 'ahui.safetyvision.no') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    define('DEVELOP_MODE','huilee');
}else{
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    define('DEVELOP_MODE','local');
}
$config=dirname(__FILE__).'/protected/config/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();