<!DOCTYPE html>
<html lang="ja">
  <head>
		<?php echo $this->Html->charset(); ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php echo $this->fetch('title'); ?></title>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/auto_complete.js"></script>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


		<?php
			echo $this->Html->meta('icon');


			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		<?php if(!Configure::read("is_develop")) { ?>
		<?php echo $this->element("analytics_element");?>
		<?php } ?>
  </head>
  <body>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/Search/">税務署検索</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="/pages/policy/">このサイトについて</a></li>
						<li><a href="/contact/">広告出稿依頼はこちら</a></li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">北海道・東北地方<span class="caret"></span></a>

          		<ul class="dropdown-menu" role="menu">
								<li><a href="/Search/hokkaido/">北海道</a></li>
								<li><a href="/Search/aomori">青森県</a></li>
								<li><a href="/Search/iwate/">岩手県</a></li>
								<li><a href="/Search/miyagi/">宮城県</a></li>
								<li><a href="/Search/akita/">秋田県</a></li>
								<li><a href="/Search/yamagata/">山形県</a></li>
								<li><a href="/Search/fukushima/">福島県</a></li>
							</ul>	
						 </li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">関東地方<span class="caret"></span></a>
          		<ul class="dropdown-menu" role="menu">
          		 	<li><a href="/Search/tokyo/">東京都</a></li>
           		 	<li><a href="/Search/kanagawa/">神奈川県</a></li>
           		 	<li><a href="/Search/chiba/">千葉県</a></li>
								<li><a href="/Search/ibaraki/">茨城県</a></li>
								<li><a href="/Search/tochigi/">栃木県</a></li>
								<li><a href="/Search/gumma/">群馬県</a></li>
								<li><a href="/Search/saitama/">埼玉県</a></li>
							</ul>	
						 </li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">中部地方<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
           		 	<li><a href="/search/yamanashi/">山梨県</a></li>
								<li><a href="/search/nagano/">長野県</a></li>
								<li><a href="/search/niigata/">新潟県</a></li>
								<li><a href="/search/toyama/">富山県</a></li>
								<li><a href="/search/ishikawa/">石川県</a></li>
								<li><a href="/search/fukui/">福井県</a></li>
								<li><a href="/search/shizuoka/">静岡県</a></li>
								<li><a href="/search/aichi/">愛知県</a></li>
								<li><a href="/search/gifu">岐阜県</a></li>
							</ul>
						 </li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">近畿地方<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/search/mie/">三重県</a></li>
								<li><a href="/search/shiga/">滋賀県</a></li>
								<li><a href="/search/kyoto/">京都府</a></li>
								<li><a href="/search/osaka/">大阪府</a></li>
								<li><a href="/search/hyogo/">兵庫県</a></li>
								<li><a href="/search/nara/">奈良県</a></li>
								<li><a href="/search/wakayama/">和歌山県</a></li>
							</ul>
						 </li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">中国・四国地方<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/search/tottori/">鳥取県</a></li>
								<li><a href="/search/shimane/">島根県</a></li>
								<li><a href="/search/okayama/">岡山県</a></li>
								<li><a href="/search/hiroshima/">広島県</a></li>
								<li><a href="/search/yamaguchi/">山口県</a></li>
								<li><a href="/search/tokushima/">徳島県</a></li>
								<li><a href="/search/kagawa/">香川県</a></li>
								<li><a href="/search/ehime/">愛媛県</a></li>
								<li><a href="/search/kochi/">高知県</a></li>
							</ul>
						 </li>
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">九州・沖縄地方<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/search/fukuoka/">福岡県</a></li>
								<li><a href="/search/saga/">佐賀県</a></li>
								<li><a href="/search/nagasaki/">長崎県</a></li>
								<li><a href="/search/kumamoto/">熊本県</a></li>
								<li><a href="/search/oita/">大分県</a></li>
								<li><a href="/search/miyazaki/">宮崎県</a></li>
								<li><a href="/search/kagoshima/">鹿児島県</a></li>
								<li><a href="/search/okinawa/">沖縄県</a></li>
							</ul>
						 </li>
						<!--
						 <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">地域から検索<span class="caret"></span></a>
          		<ul class="dropdown-menu" role="menu">
           		 	<li><a href="/search/tokyo/">東京都</a></li>
           		 	<li><a href="/search/kanagawa/">神奈川県</a></li>
           		 	<li><a href="/search/chiba/">千葉県</a></li>
           		 	<li><a href="/search/yamanashi/">山梨県</a></li>
								<li><a href="/search/ibaraki/">茨城県</a></li>
								<li><a href="/search/tochigi/">栃木県</a></li>
								<li><a href="/search/gumma/">群馬県</a></li>
								<li><a href="/search/saitama/">埼玉県</a></li>
								<li><a href="/search/niigata/">新潟県</a></li>
								<li><a href="/search/nagano/">長野県</a></li>
								<li><a href="/search/aomori">青森県</a></li>
								<li><a href="/search/iwate/">岩手県</a></li>
								<li><a href="/search/miyagi/">宮城県</a></li>
								<li><a href="/search/akita/">秋田県</a></li>
								<li><a href="/search/yamagata/">山形県</a></li>
								<li><a href="/search/fukushima/">福島県</a></li>
								<li><a href="/search/hokkaido/">北海道</a></li>
								<li><a href="/search/toyama/">富山県</a></li>
								<li><a href="/search/ishikawa/">石川県</a></li>
								<li><a href="/search/fukui/">福井県</a></li>
								<li><a href="/search/gifu">岐阜県</a></li>
								<li><a href="/search/shizuoka/">静岡県</a></li>
								<li><a href="/search/aichi/">愛知県</a></li>
								<li><a href="/search/mie/">三重県</a></li>
								<li><a href="/search/shiga/">滋賀県</a></li>
								<li><a href="/search/kyoto/">京都府</a></li>
								<li><a href="/search/osaka/">大阪府</a></li>
								<li><a href="/search/hyogo/">兵庫県</a></li>
								<li><a href="/search/nara/">奈良県</a></li>
								<li><a href="/search/wakayama/">和歌山県</a></li>
								<li><a href="/search/tottori/">鳥取県</a></li>
								<li><a href="/search/shimane/">島根県</a></li>
								<li><a href="/search/okayama/">岡山県</a></li>
								<li><a href="/search/hiroshima/">広島県</a></li>
								<li><a href="/search/yamaguchi/">山口県</a></li>
								<li><a href="/search/tokushima/">徳島県</a></li>
								<li><a href="/search/kagawa/">香川県</a></li>
								<li><a href="/search/ehime/">愛媛県</a></li>
								<li><a href="/search/kochi/">高知県</a></li>
								<li><a href="/search/fukuoka/">福岡県</a></li>
								<li><a href="/search/saga/">佐賀県</a></li>
								<li><a href="/search/nagasaki/">長崎県</a></li>
								<li><a href="/search/kumamoto/">熊本県</a></li>
								<li><a href="/search/oita/">大分県</a></li>
								<li><a href="/search/miyazaki/">宮崎県</a></li>
								<li><a href="/search/kagoshima/">鹿児島県</a></li>
								<li><a href="/search/okinawa/">沖縄県</a></li>
							 </ul>
						 </li>
						-->
					 </ul>
					 <ul class="nav navbar-nav navbar-right">
						 <!--<li><a href="mailto:&#107;&#111;&#107;&#117;&#122;&#101;&#105;&#64;&#98;&#114;&#99;&#55;&#115;&#102;&#116;&#46;&#115;&#97;&#107;&#117;&#114;&#97;&#46;&#110;&#101;&#46;&#106;&#112;">お問い合わせ</a></li>-->
						 <li><a href="https://<?php print env("SERVER_NAME")?>/contact/">お問い合わせ</a></li>
					 </ul>
				 </div>
			</div>
		</nav>


		<div id="content" class="container">
		
			<?php if(Configure::read("is_develop")) { ?><h2 class="alert alert-danger">テストサイト</h2><?php } ?>

			<div class="btn-group">
			<?php if(!Configure::read("is_develop")) { ?>
			<div class="row">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- お試し -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-2269194928323112"
				     data-ad-slot="2065128987"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>

				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- レスポンシブ　税務署検索 -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-2269194928323112"
				     data-ad-slot="3062748989"
				     data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>	
			<?php } ?>
			<!-- オンライン税理士 -->
			<div class="row">
				<hr />
				<a href="//px.a8.net/svt/ejp?a8mat=2NMJNI+7FBO62+3I9K+5YJRM" target="_blank">オンライン税理士が2,980円で！Bizer(バイザー)</a>
				<img border="0" width="1" height="1" src="http://www17.a8.net/0.gif?a8mat=2NMJNI+7FBO62+3I9K+5YJRM" alt="">
				<hr />
			</div>

			<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<div class="fb-like" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
			</div>
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

		</div>

		<div id="content" class="container">
		<!-- 広告 -->

		<?php print $this->element("ad_20161213"); ?>
		<?php if(!Configure::read("is_develop")) { ?>
		<?php } ?>	
		</div>
		<div class="panel panel-default">
			<div class="panel-footer">
				<footer class="container-fluid">
					<div class="copy text-center"><small><a href="/search">Copyright (C) <?php print date("Y")?> g-kdan-hidariyubi All Rights Reserved.</a></small>
				</footer>
			</div>
		</div>
	<?php echo $this->element('sql_dump'); ?>
  </body>
</html>

