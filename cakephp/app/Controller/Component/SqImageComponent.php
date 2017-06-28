<?php
App::uses('Component', 'Controller');
class SqImageComponent extends Component {
	private $securimage;
	//beforeFileterの後に実行される
  public function startup(Controller $controller) {
    $this->controller = $controller;
    $this->request = $controller->request;
		App::import("Vendor", "Securimage", array('file' => 'securimage/securimage.php'));
		$this->securimage = new Securimage();
	}

	public function render () {
		// $this->securimage->ttf_file = ROOT. DS. "vendors". DS. "securimage". DS. "AHGBold.ttf";
		$this->securimage->ttf_file = ROOT. DS. "vendors". DS. "securimage". DS. "BMbG.ttf";

		//$this->securimage->text_color = "#000000";
		//$this->securimage->line_color = "#707070";
		//$this->securimage->charset = "ABCDEFGHIJKLMNOPQURSUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$this->securimage->charset = "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほらりるれろやゆよわをん";
		$this->securimage->wordlist_file_encoding = "UTF-8";
		$this->securimage->image_width = 200;
		$this->securimage->image_height= 50;
		$this->securimage->show();
	}

	public function checkCharImage ($input) {
		$validate_flag = true;
		if(!$this->securimage->check($input)) {
			$validate_flag = false;
		}
		return $validate_flag;
	}

	public function outputAudio ($format = null, $namespace = null) {
		if(!empty($namespace)) {
			$this->securimage->setNamespace($namespace);
		}
		 
	 	$this->securimage->outputAudioFile($format);
	}
	
}
