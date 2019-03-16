<?php
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Detector{

	public  $impact;
	public  $reports;

	function detect_intrusion($data){
		$filters = new \Expose\FilterCollection();
		$filters->load();
		$logger = new Logger('idslog');
		$notify = new \Expose\Notify\Email();
		$logger->pushHandler(new StreamHandler('file.log', Logger::WARNING));
		$manager = new \Expose\Manager($filters, $logger);
		$notify->setToAddress('olayiwolaodunsi@gmail.com');
		$notify->setFromAddress('notify@cloudcontact.dev');
		$manager->setNotify($notify);

		$manager->run($data,false,true);
		// $manager->run($data);
		$this->impact = $manager->getImpact();
		//echo 'impact: '.$this->impact."\n";
		$this->reports = $manager->getReports();
		//print_r($reports);
		
		$logger->error($manager->export());
		return $manager->export('Arrays');
	}

}

?>