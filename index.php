<?php
define('APP_DEBUG',1);
define("APP_PATH",dirname(__FILE__));
define("LP_PATH",APP_PATH.'/bin/lovephp');
require(APP_PATH."/bin/lovephp/init.php");
daung();//启动项目
