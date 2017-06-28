		<?php $this->set('title_for_layout', (isset($title) ? $title : '税務署検索 | 東京都の税務署を検索,東京都所轄の税務署を検索' ));?>
		<?php $this->Html->meta('keywords', (isset($keywords) ? $keywords : "東京都,税務署,検索,所轄"), array('inline' => false)); ?>
		<?php $this->Html->meta('description', (isset($description) ? $description : "住所から東京都管轄の各税務署を検索します。,所轄の税務署を検索します"), array('inline' => false)); ?>
		<?php print $this->Html->css("/css/bootstrap-custom.css", array( 'inline' => false));?>
		<?php print $this->Html->css("/css/securimage.css", array( 'inline' => false));?>
		<section class="container">
			
			<h1 class="bg-primary"><span class="glyphicon glyphicon-envelope"></span> お問い合せ</h1>
			<h5 class="text-info bg-info padding10">楽曲作成(サンプル <a href="https://soundcloud.com/g_kdan_hidari_yubi" target="_blank">インスト楽曲</a>,<a href="https://www.youtube.com/user/taijiii" target="_blank">ボカロ楽曲</a>)やシステム開発のお仕事などを承っております。<br />小型コンピュータ(raspberry pi)を利用したloTやスマートフォンアプリ開発、<br />Webシステムの構築など、まずはご相談下さい。</h5>

			<div class="well bs-component">
				<?php echo $this->Form->create(null, array("url" => "confirm", "type" => "post", "name"=>"form", "id"=>"registForm") ) ?>
				<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="name"><span class="text-danger">※</span>お名前</label></div>
      	  <div class="col-sm-4 padding10">
						<?php echo $this->Form->error('Contact.name', null, array("class" => "text-danger bg-warning padding5", "wrap" => "span")); ?>
	 					<?php print $this->Form->text("Contact.name", array("class" => "form-control", "id" => "name", "maxlength" => 50, "placeholder" => "お名前を記入"));?>
      	    <!--<input value="" class="form-control" id="name" name="name" placeholder="お名前を記入" type="text">-->
      	  </div>
      	</div><!-- /行終了  -->
   			<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="address">お電話番号</label></div>
      	  <div class="col-sm-4 padding10">
						<?php echo $this->Form->error('Contact.tel', null, array("class" => "text-danger bg-warning padding5", "wrap" => "span")); ?>
	 					<?php print $this->Form->text("Contact.tel", array("class" => "form-control", "id" => "tel", "maxlength" => 50, "placeholder" => "お電話番号を記入"));?>
      	    <!--<input value="" class="form-control" id="tel" name="address" placeholder="お電話番号を記入" type="text"> -->
      	  </div>
      	</div><!-- /行終了  -->
    		<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="email">メールアドレス</label></div>
      	  <div class="col-sm-4 padding10">
						<?php echo $this->Form->error('Contact.email', null, array("class" => "text-danger bg-warning padding5", "wrap" => "span")); ?>
	 					<?php print $this->Form->email("Contact.email", array("type" => "email", "class" => "form-control", "id" => "email", "maxlength" => 50, "placeholder" => "メールアドレスを入力"));?>
      	    <!--<input value="" class="form-control" id="email" name="email" placeholder="メールアドレスを記入" type="email">-->
      	  </div>
      	</div><!-- /行終了  -->

    		<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="comment"><span class="text-danger">※</span>お問い合わせ内容</label></div>
      	  <div class="col-sm-7 padding10">
						<?php echo $this->Form->error('Contact.comment', null, array("class" => "text-danger bg-warning padding5", "wrap" => "span")); ?>
	 					<?php print $this->Form->textArea("Contact.comment", array("class" => "form-control", "id" => "comment", "rows" => "3", "placeholder" => "ご意見をどうぞ"));?>
      	    <!--<textarea class="form-control" rows="3" id="comment" placeholder="ご意見をどうぞ"></textarea>-->
      	  </div>
      	</div><!-- /行終了  -->
      	
     		<!-- 行開始  -->
      	<div class="row">
  			<!-- invisible div containing captcha audio tag, and optional flash fallback code -->
  				<div id="captcha_image_audio_div2">
    				<!-- the audio tag -->
    				<audio id="captcha_image2_audio" preload="none" style="display: none">
    	  			<!-- mp3 source tag - uncomment if you have LAME installed -->
    	  			<!-- <source id="captcha_image2_source_mp3" src="securimage_play.php?id=<?php echo uniqid() ?>&amp;format=mp3" type="audio/mpeg"> -->

    	  			<!-- wav source tag -->
    	  			<source id="captcha_image2_source_wav" src="/Contact/outputAudio?id=<?php echo uniqid() ?>" type="audio/wav">

    	  			<!-- flash player fallback - delete if you don't want flash fallback -->
							<!--<object type="application/x-shockwave-flash" data="securimage_play.swf?bgcol=%23ffffff&amp;icon_file=images%2Faudio_icon.png&amp;audio_file=/Contact/outputAudio" height="32" width="32">
    	  		 	 <param name="movie" value="securimage_play.swf?bgcol=%23ffffff&amp;icon_file=images%2Faudio_icon.png&amp;audio_file=/Contact/outputAudio" />
							</object>-->
    				</audio>
 					</div>
      	  <div class="col-sm-2 padding10"><label for="comment"><span class="text-danger">※</span>画像認証</label></div>
					<div class="col-sm-3 padding10">
						<?php echo $this->Form->error('Contact.image_char', null, array("class" => "text-danger bg-warning padding5", "wrap" => "span")); ?>
						<?php print $this->Form->text("Contact.image_char", array("class" => "form-control", "placeholder" => "下の画像文字を入力して下さい") ); ?>
						<?php print $this->Html->image('/Contact/renderSqImage/', array('alt' => 'CAPTCHA Image', "id" => "captcha_image2"));?>
 						<!-- div containing the HTML audio controls -->
  					<div id="captcha_image2_audio_controls">
  					  <!-- play button and loading image that gets toggled when audio is loading -->
  					  <a tabindex="-1" class="captcha_play_button" href="/Contact/outputAudio?id=<?php echo uniqid() ?>" onclick="return false">
								<img class="captcha_play_image" height="32" width="32" src="/img/audio_icon.png" alt="Play CAPTCHA Audio" style="border: 0px">
  					    <img class="captcha_loading_image rotating" height="32" width="32" src="/img/loading.png" alt="Loading audio" style="display: none">
  					  </a>
  					  <noscript>Enable Javascript for audio controls</noscript>
  					</div>
 						<!-- link to refresh the captcha image and audios -->
 						<a tabindex="-1" style="border: 0" href="#" title="Refresh Image" onclick="document.getElementById('captcha_image2').src = '/Contact/renderSqImage/?' + Math.random(); captcha_image2_audioObj.refresh(); this.blur(); return false">
 						  <img height="32" width="32" src="/img/refresh.png" alt="Refresh Image" onclick="this.blur()" style="border: 0px; vertical-align: bottom" />
 						</a>
 						<br>
 						<!-- javascript code for refreshing and playing captcha audio -->
 						<script type="text/javascript" src="/js/securimage.js"></script>
 						<script type="text/javascript">
 						  captcha_image2_audioObj = new SecurimageAudio({ audioElement: 'captcha_image2_audio', controlsElement: 'captcha_image2_audio_controls' });
 						  /*
 						  The SecurimageAudio object accepts a single object paramter with two properties:
 						    audioElement: the ID of the div containing the <audio> and <source> HTML tags
 						    controlsElement: the ID of the div containing the audio playback controls

 						  Note: securimage.js automatically finds the play and loading images by looking for images with
 						        class names of captcha_play_image and captcha_loading_image, respectively.

 						        The image inside of the controls div including the class name "captcha_play_image" will have
 						        click events registered to start/stop audio playback

 						        The image inside of the controls div including the class name "captcha_loading_image will be
 						        displayed with the audio is loading and hidden again once playback starts.

 						        Clicking the play button starts and stops audio playback.
 						  */
 						</script>

      	    <!--<textarea class="form-control" rows="3" id="comment" placeholder="ご意見をどうぞ"></textarea>-->
      	  </div>
      	</div><!-- /行終了  -->  

      	<div class="row">
      	  <div class="col-sm-6 padding10">
      	    <button type="submit" class="btn btn-info">確認画面へ進む <span class="glyphicon glyphicon-chevron-right"></span> </button>
      	  </div>
				</div>
			</div>
			<?php echo $this->Form->end() ?>
		</section>
