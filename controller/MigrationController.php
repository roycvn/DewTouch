<?php

include_once('models/MigrationModel.php');

class MigrationController {
	public $migModel;

	public function __construct() {    
		 $this->migModel = new MigrationModel();  
	}   

	public function invoke() {
		if(isset($_POST['uploader-button'])) {
			$stepDetails = $this->migModel->processMigration();
		}

		include 'views/migration/index.php';
	}
}