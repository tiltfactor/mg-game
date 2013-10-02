<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
// change the following paths if necessary
require_once(dirname(__FILE__).'/protected/config/consts.php');

$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
