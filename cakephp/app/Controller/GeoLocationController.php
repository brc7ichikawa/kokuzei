<?php
App::uses('AppController', 'Controller');

class GeoLocationController extends AppController {
 
 	public $layout = "basic_layout"; 
	public $uses = array("MasterTaxOffice", "SearchTaxOfficeAddress");
	public $component = array("Session");
	private $igo;
	public function test () {
	
	}

	public function showNearOffice () {
		$lat = null;
  	$lon = null;
	 	if(isset($this->data["MasterTaxOffice"])) {
			$lat = $this->data["MasterTaxOffice"]["lat"];
			$lon = $this->data["MasterTaxOffice"]["lon"];
			$this->Session->write("MasterTaxOffice", $this->data);
		} else if($this->Session->check("MasterTaxOffice")) {
			$data = $this->Session->read("MasterTaxOffice");
			$this->data = $data;
		} else {
			$this->redirect("/");
		}
		$lat = $this->data["MasterTaxOffice"]["lat"];
		$lon = $this->data["MasterTaxOffice"]["lon"];

		$param = array("fields" 
		 								=> array("id"
														, "tel"
														, "name"		
		 												, "address_no"
														, "prefecture"
														, "address1"
														, "GLength(GeomFromText(CONCAT('LineString({$lon} {$lat},', X(geo_location), ' ', Y(geo_location),')'))) AS len ")
														, "order" => "len"
														, "limit" => 15
													 );
		$res = $this->__getPaginate("MasterTaxOffice", $param, 15);
		$this->set("master_tax_office", $res);
		// pr($res);
		//	exit;
		// $this->MasterTaxOffice
		
		$this->render("/Search/index/");
	}

	public function getGeoLocation ($offset = 0) {
		$json_url = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&language=ja&sensor=false";
		$master_tax_office = $this->MasterTaxOffice->find("all", array("conditions" => array("geo_location IS NULL"), "order" => "id", "limit" => 10, "offset" => $offset));
		for($i = 0; $i < count($master_tax_office); $i++) {
		 	$req_url = str_replace("%s", str_replace("-", "", trim($master_tax_office[$i]["MasterTaxOffice"]["address_no"])), $json_url);
			$contents = file_get_contents($req_url);
			$parse_data = json_decode($contents, true);
			if(!isset($parse_data["results"][0])) {
			 	$adr = trim($master_tax_office[$i]["MasterTaxOffice"]["prefecture"]). trim($master_tax_office[$i]["MasterTaxOffice"]["address1"]);
				$adr = str_replace(array(" ", "　"), "", $adr);
		 		$req_url = str_replace("%s", $adr, $json_url);
				$contents = file_get_contents($req_url);
				$parse_data = json_decode($contents, true);
			}
			print trim($master_tax_office[$i]["MasterTaxOffice"]["address_no"]). "<br />";
			if(isset($parse_data["results"][0])) {
				$lat = (isset($parse_data["results"][0])) ? $parse_data["results"][0]["geometry"]["location"]["lat"] : $parse_data["results"]["geometry"]["location"]["lat"];
				$lng = (isset($parse_data["results"][0])) ? $parse_data["results"][0]["geometry"]["location"]["lng"] : $parse_data["results"]["geometry"]["location"]["lng"];
				print $master_tax_office[$i]["MasterTaxOffice"]["id"]. "\t". $master_tax_office[$i]["MasterTaxOffice"]["name"]. "\t". 
			 	$master_tax_office[$i]["MasterTaxOffice"]["prefecture"]. $master_tax_office[$i]["MasterTaxOffice"]["address1"]. "\t". 
			 	$lat. "\t". 
			 	$lng. "\n<br />";

				$master_tax_office[$i]["MasterTaxOffice"]["geo_location"] = "GeomFromText('POINT({$lng} {$lat})')"; // array($lat, $lng);
				$this->MasterTaxOffice->begin();
			 	$r = $this->MasterTaxOffice->query("UPDATE master_tax_offices set geo_location={$master_tax_office[$i]["MasterTaxOffice"]["geo_location"]} WHERE id=". $master_tax_office[$i]["MasterTaxOffice"]["id"]);
				$this->MasterTaxOffice->commit();
				
				
			} else {
				pr($parse_data);
			}
			// exit;
		}
		$this->set("master_tax_office", $master_tax_office);
		exit;
	}

}
?>
