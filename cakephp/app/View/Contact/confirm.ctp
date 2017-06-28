		<?php $this->set('title_for_layout', (isset($title) ? $title : '税務署検索 | 東京都の税務署を検索,東京都所轄の税務署を検索' ));?>
		<?php $this->Html->meta('keywords', (isset($keywords) ? $keywords : "東京都,税務署,検索,所轄"), array('inline' => false)); ?>
		<?php $this->Html->meta('description', (isset($description) ? $description : "住所から東京都管轄の各税務署を検索します。,所轄の税務署を検索します"), array('inline' => false)); ?>
		<?php print $this->Html->css("/css/bootstrap-custom.css", array( 'inline' => false));?>
		<?php $this->Html->scriptStart(array('inline' => false)); ?>
			$(function () {
				$("#back_button").click(function () {
					$(form).attr("action", "index"); 
					$(form).submit(); 
				})
			});
		<?php $this->Html->scriptEnd(); ?>
		<section class="container">
			
  		<h1 class="bg-primary"><span class="glyphicon glyphicon-envelope"></span> お問い合せ</h1>
			<h5 class="text-danger bg-danger padding10">※お問い合わせ内容によってはご回答に数日時間を頂く場合がございます。<br />※本業が多忙の場合、お仕事の内容によっては請け負いかねる場合が御座います。<br />予めご了承頂きます様、お願い申し上げます。</h5>
			<div class="well bs-component">
				<?php echo $this->Form->create(null, array("url" => "save", "type" => "post", "name"=>"form", "id"=>"registForm") ) ?>
				<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="name"><span class="text-danger">※</span>お名前</label></div>
      	  <div class="col-sm-4 padding10">
						<p><?php print h($contact["name"])?></p>
	 					<?php print $this->Form->hidden("Contact.name", array("value" => h($contact["name"])));?>
      	  </div>
      	</div><!-- /行終了  -->
   			<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="address">お電話番号</label></div>
      	  <div class="col-sm-4 padding10">
						<p><?php print h($contact["tel"])?></p>
	 					<?php print $this->Form->hidden("Contact.tel", array("value" => h($contact["tel"])));?>

      	    <!--<input value="" class="form-control" id="tel" name="address" placeholder="お電話番号を記入" type="text"> -->
      	  </div>
      	</div><!-- /行終了  -->
    		<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="email">メールアドレス</label></div>
      	  <div class="col-sm-4 padding10">
						<p><?php print h($contact["email"])?></p>
	 					<?php print $this->Form->hidden("Contact.email", array("value" => h($contact["email"])));?>
      	    <!--<input value="" class="form-control" id="email" name="email" placeholder="メールアドレスを記入" type="email">-->
      	  </div>
      	</div><!-- /行終了  -->

    		<!-- 行開始  -->
      	<div class="row">
      	  <div class="col-sm-2 padding10"><label for="comment"><span class="text-danger">※</span>お問い合わせ内容</label></div>
      	  <div class="col-sm-7 padding10">
						<p><?php print nl2br( h($contact["comment"]) )?></p>
	 					<?php print $this->Form->hidden("Contact.comment", array("value" => h($contact["comment"])));?>
	 					<?php print $this->Form->hidden("Contact.image_char", array("value" => h($contact["image_char"])));?>
      	    <!--<textarea class="form-control" rows="3" id="comment" placeholder="ご意見をどうぞ"></textarea>-->
      	  </div>
      	</div><!-- /行終了  -->
      	
    
      	<div class="row">
      	  <div class="col-sm-10 padding10">
						<button id="back_button" type="button" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span>修正 </button> 
      	    <button type="submit" class="btn btn-info">ご注意に同意して送信する <span class="glyphicon glyphicon-chevron-right"></span> </button>
      	  </div>
				</div>
			</div>
			<?php echo $this->Form->end() ?>
		</section>

