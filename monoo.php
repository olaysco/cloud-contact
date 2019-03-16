<?php
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('file.log', Logger::WARNING));
$log->warning('Foo');
$log->error('Bar');
?>