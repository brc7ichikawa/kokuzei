$(function(){
 	var is_mobile = ($("#is_mobile").val() == "true");
	if(!is_mobile) {
		is_mobile = /Android|webOS|iPhone|iPad|iPod|pocket|psp|kindle|avantgo|blazer|midori|Tablet|Palm|maemo|plucker|phone|BlackBerry|symbian|IEMobile|mobile|ZuneWP7|Windows Phone|Opera Mini/i.test(navigator.userAgent);	
	}
	if (is_mobile) {
		$(".th_address_no,.th_address,.th_zaimu,.th_tel,.td_tel").hide();
		$(".td_address_no,.td_address,.td_zaimu,#news_doc").hide();

		$(".th_name").html("住所　名前");
		$(".th_tax_offices").html("管轄　<button id='other' class='btn btn-info btn-xs'>その他>></button>");
		
		$("#news_doc").before("<button id='news_show' class='btn btn-info' style='margin-bottom:15px'>お知らせを表示▲</button>"); 
		
		// $("a[link_id=]")
		//$(".map").attr("style", "padding-right:5px");
		$(".map").html("<button name='bt_link'><img width='25px' src='/img/map2.png'></button>");
		$("button[name=bt_link]").click(function () {
			var map_link_id = $(this).parent().attr("map_link_id");
			window.open($("a[map_link_id=" + map_link_id + "]").attr("href"));
			//alert(map_link_id);
			return false;
		});


		$('#address_name').keypress(function (e) {
			if (e.which == 13) {
				// ここに処理を記述
				$("#registForm").submit();
				return false;
			}
		});

		$("#other").click(function () {
			$(".th_tax_offices,.td_tax_offices").hide();

			$(".th_zaimu").html("税務署番号　<button id='return' class='btn btn-info btn-xs'><<戻る</button>");
			$(".th_tel,.td_tel,.th_zaimu,.td_zaimu").show();

			$("#return").click(function () {
			 	$(".th_zaimu,.td_zaimu,.th_tel,.td_tel").hide();
	
				$(".th_tax_offices,.td_tax_offices").show();
				localStorage.setItem("other_click", "false");
				return false;
			});
			localStorage.setItem("other_click", "true");
			return false;
		});

		$("#news_show").click(function () {
			$("#news_doc").toggle();
			if($(this).html() != "お知らせを隠す▼" ) {
				$(this).html("お知らせを隠す▼");
			} else {
				$(this).html("お知らせを表示▲");
			}
		});
		
		if(!localStorage.getItem("hide_news")) {
			$("#news_show").trigger("click");
			localStorage.setItem("hide_news", true);
		}
		if(localStorage.getItem("other_click") == "true") {
			$("#other").trigger("click");
		}
	}
});
