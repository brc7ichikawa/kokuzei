<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

 /**
	 * トリム共通
	 * @param unknown_type $value
	 */
	function __trimData(&$value, $key, $strip_tags = true) {
	 	if(!is_array($value)) {
		 
			$value = trim($value);
		 	if($strip_tags) {
				$value = strip_tags($value);
			}
		} else {
			foreach ($value as $key=>$vl) {
				$value[$key] = trim($vl);
				if($strip_tags) {
					$value[$key] = strip_tags($value[$key]);
				}
			}
		}
	}

 	public function __getPaginate ($name, $params, $limit = 100000, $offset = null, $page = 1) {
		$data_array = array();
		$data_array[$name] = $params;
		$data_array[$name]["limit"] = ($offset) ? "{$offset},{$limit}" : $limit;
		$data_array[$name]["page"] = $page;
		$this->paginate = array_merge( $data_array, $this->paginate);
		// pr($this->paginate);
		return $this->paginate($name);
	}
	
	public function appError($error) {
 		$this->redirect(array('controller' => 'Search', 'action' => 'index'));
	}

	public function toS () {
		if(!isset($_SERVER['HTTPS'])) {
			header("location: ".'https://'. env("SERVER_NAME"). $_SERVER['REQUEST_URI']);
		}
	}

}
