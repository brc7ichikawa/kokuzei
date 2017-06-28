<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * お問い合わせ
 */
class ContactController extends AppController {
	public $layout = "basic_layout"; 
	public $uses = array("Contact");
 	var $components = array("SqImage", 'Session');
	public $Email = null;

	public function beforeFilter () {
		$this->set("title", "税務署検索 | お問い合わせ 管轄の税務署を検索,所轄の税務署を検索");
		$this->set("keywords", "税務署,検索,所轄");
		$this->set("description", "お問い合わせ | ご住所から管轄税務署を検索します。ご住所から所轄の税務署を検索します。");
		$this->Email = new CakeEmail();
	}

	public function index () {
	}

	// 確認画面表示
	public function confirm () {
		$render = "confirm";
		if(!isset($this->data["Contact"])) {
	 		$this->redirect("index");
		}
		$this->Contact->set($this->data["Contact"]);
		$this->Contact->setCharImage($this->SqImage->checkCharImage($this->data["Contact"]["image_char"]));
		$this->Session->write("image_char", $this->data["Contact"]["image_char"]);	
		if(!$this->Contact->validates()) {
		 	$render = "index";
		}
		$dta = $this->data;
		array_walk($dta["Contact"], array($this, "__trimData"));	//トリム
		$this->data = array_merge($this->data, $dta);
		$this->set("contact", $this->data["Contact"]);
		$this->render($render);
	}

	// データ挿入
	public function save () {
	 	$sess_im = $this->Session->read("image_char");
		$this->Session->delete("image_char");
		if(!isset($this->data["Contact"]) || $this->data["Contact"]["image_char"] != $sess_im) {
			$this->redirect("index");
		}
		unset($this->request->data['Contact']["image_char"]);
		array_walk($this->request->data['Contact'], array($this, "__trimData"));	//トリム
		if($this->Contact->insertData($this->data["Contact"])) {
		 	// todo メール送信処理
			$from = (empty($this->data["Contact"]["email"]) ? Configure::read("contact_mail") : $this->data["Contact"]["email"]);
			$this->Email->from(array($from => $this->data["Contact"]["name"]));
			$this->Email->to(Configure::read("contact_mail"));
			$this->Email->subject('お問い合わせがありました');
			$this->Email->send($this->makeMessage());	
		}
		$this->redirect("thanks");
	}

	// 
	public function thanks () {}

	public function makeMessage () {
	 	$res = "";
	 	if(isset($this->data["Contact"])) {
			$res = "お名前:". $this->data["Contact"]["name"]. "\n";
			$res .= "email:". $this->data["Contact"]["email"]. "\n";
			$res .= "お電話番号:". $this->data["Contact"]["tel"]. "\n";
			$res .= "お問合わせ内容:". $this->data["Contact"]["comment"]. "\n";
		}
		return $res;
	}

	public function renderSqImage () {
		$this->SqImage->render();
	}
	// オーディオ作成
	public function outputAudio ($format = null, $namespace = null) {
		$this->SqImage->outputAudio($format, $namespace);
	}

}
?>
