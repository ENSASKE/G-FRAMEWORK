<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT.DS.'config'.DS.'config.php');

#$backupFile = BASEDATOS.'_data'.date("-YmdHis").'.db';
#$command = 'mysqldump --opt -h'.SERVIDOR.' -u'.USUARIO.' -p'.PASSWORD.' '.BASEDATOS.' no-data add-drop-table > '.$backupFile;
#system($command);

$backupFile = ROOT.DS.'db'.DS.BASEDATOS.date("-YmdHis").'.sql';
$command = 'mysqldump --opt -h'.SERVIDOR.' -u'.USUARIO.' -p'.PASSWORD.' '.BASEDATOS.' > '.$backupFile;
system($command);

