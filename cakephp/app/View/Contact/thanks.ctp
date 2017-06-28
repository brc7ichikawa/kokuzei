		<?php $this->set('title_for_layout', (isset($title) ? $title : '税務署検索 | 東京都の税務署を検索,東京都所轄の税務署を検索' ));?>
		<?php $this->Html->meta('keywords', (isset($keywords) ? $keywords : "東京都,税務署,検索,所轄"), array('inline' => false)); ?>
		<?php $this->Html->meta('description', (isset($description) ? $description : "住所から東京都管轄の各税務署を検索します。,所轄の税務署を検索します"), array('inline' => false)); ?>
		<?php print $this->Html->css("/css/bootstrap-custom.css", array( 'inline' => false));?>
		<section class="container">
			
			<h1 class="bg-primary"><span class="glyphicon glyphicon-envelope"></span> お問い合せ</h1>
			<h5 class="text-info bg-info padding10">お問い合わせ頂きありがとうございました。内容を確認し、折り返しご連絡致します。</h5>
      <div class="row">
      	<div class="col-sm-6 padding10">
      	    <button type="button" class="btn btn-info" onclick="location.href='/'">戻る </button>
      </div>
		</section>
