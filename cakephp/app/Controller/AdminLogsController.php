<?php 
App::uses('AppController', 'Controller');

class AdminLogsController extends AppController {
	public $layout = "basic_layout"; 
	public $uses = array("MasterTaxOffice", "SearchTaxOfficeAddress", "SearchLog");
	public $component = array("Session");

	public function showLogList () {
		
	}

	public function showLogDetail ($id = null) {
	 	$seach_log = $this->SearchLog->read(null, $id);
		if(!isset($seach_log["SearchLog"])) {
			$this->error();
		} else {
		 	$this->set("search_log", $search_log);
			$this->render("show_log_detail");
		}
	}

	public function error () {
	}
}
