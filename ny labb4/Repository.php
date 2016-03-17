<?php

namespace model;



// Kodstruktur snodd av Emil Carlsson, föreläsning 6 - Webbutveckling med PHP.
abstract class Repository {
	protected $dbUsername = 'nalaka_se';
	protected $dbPassword = 'blommprinsen28';
	protected $dbConnstring = 'mysql:host=nalaka.se.mysql;dbname=nalaka_se';
	protected $dbConnection;
	protected $dbTable;
	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		//    $this->dbConnection = ($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}