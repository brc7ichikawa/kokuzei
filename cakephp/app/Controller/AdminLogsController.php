<?php 
App::uses('AppController', 'Controller');

class AdminLogController extends AppController {
	public $layout = "basic_layout"; 
	public $uses = array("MasterTaxOffice", "SearchTaxOfficeAddress");
	public $component = array("Session");

	public function showLog () {
	}
}
