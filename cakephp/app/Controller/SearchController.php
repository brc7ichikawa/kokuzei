<?php
App::uses('AppController', 'Controller');

class SearchController extends AppController {
	public $layout = "basic_layout"; 
	public $uses = array("MasterTaxOffice", "SearchTaxOfficeAddress");
	public $component = array("Session");
	private $igo;

	public function beforeFilter () {
	}

 	public function index () {
		// $this->set();
	}


	public function json () {
	 	$this->layout = false;
		if(!isset($_REQUEST["address_name"])) {
			exit; 
		}
		$this->data = $this->data + array("SearchTaxOfficeAddress" => array("address_name" => $_REQUEST["address_name"]));
		$this->searchAddress();
		$this->render("json");
	}

	public function search_detail ($id = 1) {
	 	if(strpos($id, ".html") !== false) {
			$id = str_replace(".html", "", $id);
		}
		$searchDetail = $this->SearchTaxOfficeAddress->read(null, $id);
		//pr($searchDetail);exit;
		$data_array = array("SearchTaxOfficeAddress" => array("address_name" => $searchDetail["SearchTaxOfficeAddress"]["prefecture"]. $searchDetail["SearchTaxOfficeAddress"]["city_name"].$searchDetail["SearchTaxOfficeAddress"]["address_name"]));
		$this->data = array_merge($this->data, $data_array);
		$this->searchAddress();
	}

	public function searchAddress () {
		//$this->log($this->data, LOG_INFO);	
		if(!isset($this->data["SearchTaxOfficeAddress"]) && $this->Session->check("search_tax_office_addres")) {
		 	$search_tax_office_address = $this->Session->read("search_tax_office_addres");
			$data_array = array("SearchTaxOfficeAddress" => $search_tax_office_address);
			$this->data = array_merge($this->data, $data_array);
		}
		// $this->log(mb_strlen($this->data["SearchTaxOfficeAddress"]["address_name"], "UTF-8"). "文字", LOG_INFO);
		if(isset($this->data["SearchTaxOfficeAddress"]) 
		 && !empty($this->data["SearchTaxOfficeAddress"]["address_name"]) 
		 && mb_strlen($this->data["SearchTaxOfficeAddress"]["address_name"], "UTF-8") <= 50 ) {

		 	$this->Session->write("search_tax_office_addres", $this->data["SearchTaxOfficeAddress"]);
			$data = $this->getIgoData();
			//pr($data);exit;
			$rs2 = $this->findTaxOffice($data);
			//pr($rs2);exit;
			$master_id = array();
			$address_except = "";
			$res_complete = array();
			for($i = 0; $i < count($rs2); $i++) {
				$master_id[$rs2[$i]["SearchTaxOfficeAddress"]["tax_office_id"]][] = $rs2[$i]["SearchTaxOfficeAddress"];
			}
	
			// 結果が1件以上あればクッキーに保存
			if(count($master_id) > 0) {
				$this->setAddressNameToCookie($this->data["SearchTaxOfficeAddress"]["address_name"]);
			} else {
				// 検索候補表示
			 	$data["pref"] = (!empty($data["pref"]) ? $data["pref"] : $this->data["SearchTaxOfficeAddress"]["address_name"]); 
				$res_complete = $this->makeCompleteData($data);	
			}


			$this->set("tax_offices", $master_id);
			$params = array("field" => array("id", "name", "address_no", "prefecture", "address1", "tel"),"conditions" => array("id" => array_keys($master_id)), "order" => "name");
			$master_tax_office = $this->__getPaginate("MasterTaxOffice", $params, 15);
			$this->set("master_tax_office", $master_tax_office);
			$search_contents = $this->data["search_contents"]; 
			$this->set("complete_data", $res_complete);
			$this->set("address_name", $search_contents);
			$this->set("title", "税務署検索 | ". $search_contents. "管轄の税務署を検索,". $search_contents. "所轄の税務署を検索");
			$this->set("keywords", $data["pref"]. ",". (!empty($data["city"]) ? $data["city"]. "," : "" ). (!empty($data["other"]) ? $data["other"]. "," : "" ). "税務署,検索,所轄");
			$this->set("description", "ご住所、". $search_contents. "から管轄税務署を検索します。ご住所、". $search_contents. "から所轄の税務署を検索します。");
		}
		$this->render("index");
	}

	private function getIgoData () {
		require_once(APPLIBS. "igo-php-0.1.7/lib/Igo.php");
		//print ;	
		$this->igo = new Igo(dirname(dirname(dirname(dirname(__FILE__)))). DS. "ipadic". DS);
		$search_contents = strip_tags (mb_convert_kana($this->data["SearchTaxOfficeAddress"]["address_name"], 'KVas', 'UTF-8'));
		$search_contents = trim($search_contents);
		$this->data += array("search_contents" => $search_contents);
		//$this->log("search=".$search_contents, LOG_INFO);
		$res = $this->igo->parse($search_contents);
		$data = ($this->parseIgoData($res));
		// $this->log($data, LOG_INFO);
		return $data;
	}

// 	public function getCityName () {
// 		$m_tx_ofs = $this->MasterTaxOffice->find("all");
// 		for($i = 0; $i < count($m_tx_ofs); $i++) {
// 			$city_name = $m_tx_ofs[$i]["MasterTaxOffice"]["address1"];
// 			// print $city_name. "<br />";
// 			$parse_city = $this->parseIgoData($this->igo->parse("東京都".$city_name));
// 			print $m_tx_ofs[$i]["MasterTaxOffice"]["id"]. "\t". $parse_city["city"]. "\n<br />";
// 		}
// 		exit;
// 	}

	public function findTaxOffice ($data) {
		$params = array("group" => array("city_name", "address_name"), "conditions" => array("prefecture" => $data["pref"]));
	 	$other_search = "";
		if(!empty($data["city"])) {
		 	// $params["group"] = "address_name";
			$params["conditions"]["city_name"] = $data["city"];
		}
		if(!empty($data["other"])) {
		 	if(strpos($data["other"], "区") !== false) {
				$sp_block = explode("区",$data["other"]);
				$data["other"] = $sp_block[0]. "区";
				$other_search = $data["other"]. $sp_block[1];
		 	} 

			$params["conditions"][] = array("OR" => array (
			 																							 array("address_name LIKE" => $data["other"]. "%")
																										 , array("address_name" => "")
		 																								)
																			);
			
		}

		if(!empty($data["chou"])) {
			$params["conditions"][] = array ("OR" => array(
																					array("AND" => array("city_address_from <= " => $data["chou"], "city_address_to >= " => $data["chou"]))
																					,array("AND" => array( "city_address_from" => NULL, "city_address_to" => NULL))
																				)
																			);
			//$params["conditions"]["city_address_to >= "] = $data["chou"];
		}


		if(!empty($data["ban"])) {
			$params["conditions"][] = array ("OR" => array(
																					array("AND" => array("st_address_from <= " => $data["ban"], "st_address_to >= " => $data["ban"]))
																					,array("AND" => array( "st_address_from" => NULL, "st_address_to" => NULL))
																				 )
																			);
		}

		if(!empty($data["gou"])) {
			$params["conditions"][] = array ("OR" => array(
																					array("AND" => array("go_address_from <= " => $data["gou"], "go_address_to >= " => $data["gou"]))
																					,array("AND" => array( "go_address_from" => NULL, "go_address_to" => NULL))
																				 )
																			);
		}
		//$res = $this->__getPaginate("SearchTaxOfficeAddress", $params, 15);
		$params["fields"] = array("id", "tax_office_id", "city_name", "address_name");
		// pr($params);
		$res = $this->SearchTaxOfficeAddress->find("all", $params);
		//$test = $this->SearchTaxOfficeAddress->find("all", array("id" => 1));
		//pr($test);
		$res2_ = array();
		if(!empty($other_search)) {
		 
		 	for($i = 0;$i < count($res); $i++) {
				if( strpos($res[$i]["SearchTaxOfficeAddress"]["address_name"], $other_search) !== false) {
					$res2_[] = $res[$i];
				}
			}
			if(count($res2_) != 0) {
				$res =$res2_;
			}
		}
		//if(!empty())
		return $res; 
	}

	public function parseIgoData ($obj) {
	 	// pr($obj);
		$pref_ar = array("都", "道", "府", "県");
		$city_ar = array("市", "区", "町", "村", "郡");
		$other_ar = array("町", "目");
		$pref = "";
		$city = "";

		$other = "";
		$chou = "";
		$ban = "";
		$gou = "";
		
		$num = "";
		$pref_flag = true;
		$city_flag = true;
		$oh_flag = true;
		for($i = 0; $i < count($obj); $i ++ ) {
			$surface = $obj[$i]->surface;
			$feature = $obj[$i]->feature;

			if ($pref_flag) {
				$pref .= $surface;
			} else if(!$pref_flag && $city_flag) {
				$city .= $surface;
			}	else if(!$pref_flag && !$city_flag && !is_numeric($surface) && $oh_flag) {
				$other .= $surface;
			} else {
				$num .= $surface;
			}
			
			if ($pref_flag && mb_strlen($surface, "UTF-8") == 1 && strpos($feature, "地域") !== false && in_array($surface, $pref_ar)) {
				$pref_flag = false;	
			} else if($surface == "北海道") {
				$pref_flag = false;
			}

			if(!$pref_flag && $city_flag && mb_strlen($surface, "UTF-8") == 1 && strpos($feature, "地域") !== false && in_array($surface, $city_ar)) {
				$city_flag = false;	
				//print $city;exit;
				//print $surface;exit;
			}

			if(!$pref_flag && !$city_flag && $oh_flag && is_numeric($surface)) {
				$oh_flag = false;
			}
		}	
		$matches = null;
		// print $num;exit;
		$returnValue = preg_match_all('/[\\d]+/', $num, $matches, PREG_PATTERN_ORDER);
		if(isset($matches[0])) {
			$chou = (isset($matches[0][0]) ? $matches[0][0] : "");
			$ban = (isset($matches[0][1]) ? $matches[0][1] : "");
			$gou = (isset($matches[0][2]) ? $matches[0][2] : "");
		}
		$other2 = null;
		// 北海道でotherに(町)がつく場合
		if($pref == "北海道") {
			for($i = 0;$i < count($other_ar); $i++) {
				$delimiter = $other_ar[$i];
				if(strpos($other, $delimiter) != false) {
				  $exp_ar = explode($delimiter, $other);
					$other = (isset($exp_ar[0]) ? $exp_ar[0]. $delimiter : $other);
					$other2 = (isset($exp_ar[1]) ? $exp_ar[1] : "");
				}
			}
		}
 
		return array("pref" => $pref, "city" => $city, "other" => $other, "other2" => $other2, "chou" => $chou, "ban" => $ban, "gou" => $gou);
	}

	public function tokyo () { $this->dataMerge("東京都");$this->searchAddress(); }
	public function kanagawa () { $this->dataMerge("神奈川県");$this->searchAddress(); }
	public function chiba () { $this->dataMerge("千葉県");$this->searchAddress(); }
	public function yamanashi () { $this->dataMerge("山梨県");$this->searchAddress(); }
	public function ibaraki () { $this->dataMerge("茨城県");$this->searchAddress(); }
	public function tochigi () { $this->dataMerge("栃木県");$this->searchAddress(); }
	public function gumma () { $this->dataMerge("群馬県");$this->searchAddress(); }
	public function saitama () { $this->dataMerge("埼玉県");$this->searchAddress(); }
	public function niigata () { $this->dataMerge("新潟県");$this->searchAddress(); }
	public function nagano () { $this->dataMerge("長野県");$this->searchAddress(); }
	public function aomori () { $this->dataMerge("青森県");$this->searchAddress(); }
	public function iwate () { $this->dataMerge("岩手県");$this->searchAddress(); }
	public function miyagi () { $this->dataMerge("宮城県");$this->searchAddress(); }
	public function akita () { $this->dataMerge("秋田県");$this->searchAddress(); }
	public function yamagata () { $this->dataMerge("山形県");$this->searchAddress(); }
	public function fukushima () { $this->dataMerge("福島県");$this->searchAddress(); }
	public function hokkaido () { $this->dataMerge("北海道");$this->searchAddress(); }
	public function toyama () { $this->dataMerge("富山県");$this->searchAddress(); }
	public function ishikawa () { $this->dataMerge("石川県");$this->searchAddress(); }
	public function fukui () { $this->dataMerge("福井県");$this->searchAddress(); }
	public function gifu () { $this->dataMerge("岐阜県");$this->searchAddress(); }
	public function shizuoka () { $this->dataMerge("静岡県");$this->searchAddress(); }
	public function aichi () { $this->dataMerge("愛知県");$this->searchAddress(); }
	public function mie () { $this->dataMerge("三重県");$this->searchAddress(); }
	public function shiga () { $this->dataMerge("滋賀県");$this->searchAddress();	}
	public function kyoto () { $this->dataMerge("京都府");$this->searchAddress();	}
	public function osaka () { $this->dataMerge("大阪府");$this->searchAddress();	}
	public function hyogo () { $this->dataMerge("兵庫県");$this->searchAddress();	}
	public function nara () { $this->dataMerge("奈良県");$this->searchAddress(); }
	public function wakayama () { $this->dataMerge("和歌山県");$this->searchAddress(); }

	public function	tottori () { $this->dataMerge("鳥取県");$this->searchAddress(); }
	public function	shimane () { $this->dataMerge("島根県");$this->searchAddress(); }
	public function	okayama () { $this->dataMerge("岡山県");$this->searchAddress(); }
	public function	hiroshima () { $this->dataMerge("広島県");$this->searchAddress(); }
	public function	yamaguchi () { $this->dataMerge("山口県");$this->searchAddress(); }
	public function tokushima () { $this->dataMerge("徳島県");$this->searchAddress(); }	
	public function kagawa () { $this->dataMerge("香川県");$this->searchAddress(); }
	public function ehime () { $this->dataMerge("愛媛県");$this->searchAddress(); }
	public function kochi () { $this->dataMerge("高知県");$this->searchAddress(); }

	public function fukuoka () { $this->dataMerge("福岡県");$this->searchAddress(); }
	public function saga () { $this->dataMerge("佐賀県");$this->searchAddress(); }
	public function nagasaki () { $this->dataMerge("長崎県");$this->searchAddress(); }

	public function kumamoto () { $this->dataMerge("熊本県");$this->searchAddress(); }
	public function oita () { $this->dataMerge("大分県");$this->searchAddress(); }
	public function miyazaki () { $this->dataMerge("宮崎県");$this->searchAddress(); }
	public function kagoshima () { $this->dataMerge("鹿児島県");$this->searchAddress(); }
	public function okinawa () { $this->dataMerge("沖縄県");$this->searchAddress(); }

	private function  dataMerge($address_name) {
	 	$search_tax_office_address = array("address_name" => $address_name);
		$data_array = array("SearchTaxOfficeAddress" => $search_tax_office_address);
		$this->data = array_merge($this->data, $data_array);
	}

	/**
	 * 
	 */
	public function setAddressNameToCookie ($input) {
		if(!isset($_COOKIE["search_tax_office_addres"])) {
	 		$_COOKIE["search_tax_office_addres"] = ",". $input;
			setcookie("search_tax_office_addres", $input);
		} else {
		 	$exp = explode(",", $_COOKIE["search_tax_office_addres"]);

			// $this->log("count=". count($exp), LOG_INFO);
			if(count($exp) >= 5) {
				unset($exp[count($exp) - 1]);
			}
			setcookie("search_tax_office_addres", ",". $input. $_COOKIE["search_tax_office_addres"]);
			// $_COOKIE["search_tax_office_addres"] .= ",". $input;
		}
		// $this->log($_COOKIE, LOG_INFO);
	}

	/**
	 * 入力補完用
	 */
	public function ajaxAutoCompleteDataList () {
		$this->layout = false;
		if(isset($_REQUEST["address_name"])) {
			$this->dataMerge($_REQUEST["address_name"]);
		}
		$res = $this->getIgoData();
		$sys_res = $this->makeCompleteData($res);

		$this->set("master_tax_office", $sys_res);
		$this->render("json");
	}

	private function makeCompleteData ($igo_data) {
		$sys_res = array();	
		if(isset($igo_data["pref"]) && !empty($igo_data["pref"])) {
		 
		 	if(strpos($igo_data["other"], "区") !== false) {
				$sp_block = explode("区", $igo_data["other"]);
				$igo_data["other"] = $sp_block[1];
				$igo_data["city"] = $igo_data["city"]. $sp_block[0]. "区";
			}

			$add_grep = "";
			$not_pref_city = !in_array(mb_substr($igo_data["pref"], -1), array("都", "道", "府", "県", "市"));
			if(isset($igo_data["other"]) && !empty($igo_data["other"])) {
				$add_grep = " grep -i '{$igo_data["other"]}' | sed -e 's/,//' | ";
			} else if($not_pref_city) {
				$add_grep = "sed -e 's/,//' | ";
			}
			$add_cut = ((!empty($add_grep) || $not_pref_city) ? ",3" : "");
			exec("grep -i '{$igo_data["pref"]}' ". APPLIBS. DS. "ken_all_cmp.csv | grep -i '{$igo_data["city"]}' | {$add_grep} cut -d ',' -f1,2{$add_cut} | uniq | sed -e 's/,//'", $sys_res);
		}
		return $sys_res;
	}

	public function searchFromCookie ($input_array) {
	 	$res_array = array();
		//$this->log("")
		if(isset($_COOKIE["search_tax_office_addres"]))	{
		 	$exp = explode(",", $_COOKIE["search_tax_office_addres"]);
			for($i = 0; $i < count($exp); $i++) {
				if(mb_strpos($exp[$i], $input_array["pref"]) !== false || mb_strpos($exp[$i], $input_array["city"]) !== false) {
					$res_array[] = $exp[$i];
				}	
			}
		}
		//$this->log($res_array, CK);
		return $res_array;
	}

//	public function kanToNum ($input) {
//		$input = str_replace(array("一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "零"), array(1,2,3,4,5,6,7,8,9,10,0), $input);
//		// $num = 
//	}
 	
}
