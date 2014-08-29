<?php
//Start Flag cms
define('CMS', true);
//Base Path
define('BASE_PATH', str_replace('\\', '/', realpath(dirname(__FILE__))));
//include load system
include_once(BASE_PATH.'/system.php');
//Bootstrap App to start cms
include_once(BASE_PATH.'/start.php');
?>
