<?php
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$_POST = array(
		'POST' => array(
		'test'=>'foo',
		'bar'=>array(
			'baz' => 'quux',
			'testing' => '<script>test</script>'
			)
		)

);

$filters = new \Expose\FilterCollection();
$filters->load();
$logger = new Logger('idslog');
$notify = new \Expose\Notify\Email();
$logger->pushHandler(new StreamHandler('file.log', Logger::WARNING));
$manager = new \Expose\Manager($filters, $logger);
$notify->setToAddress('olayiwolaodunsi@gmail.com');
$notify->setFromAddress('phpids@gmail.com');
//$manager->setNotify($notify);

//$manager->run($data,false,true);
$manager->run($_GET + $_POST + $_REQUEST);
echo 'impact: '.$manager->getImpact()."\n";
$reports = $manager->getReports();
//print_r(gettype($manager->export('Arrays')));
var_dump($manager->export('Arrays'));

//echo $manager->export();
echo "\n\n";
$logger->error($manager->export());
?>