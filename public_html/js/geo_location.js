$(function () {
	$("#bt_mylocation").click(function () {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition (function (geo_location) {
				$('form').remove();
				lat = geo_location.coords.latitude;
				lon = geo_location.coords.longitude;
				// $("#lat").val(lat);
				// $("#lon").val(lon);

				$('<form/>', {action: '/GeoLocation/showNearOffice', method: 'post'})
  				.append($('<input/>', {type: 'hidden', name: 'data[MasterTaxOffice][lat]', value: lat}))
  				.append($('<input/>', {type: 'hidden', name: 'data[MasterTaxOffice][lon]', value: lon}))
  				.appendTo(document.body)
  				.submit();
			}
			, function (error) {
				// エラーコードのメッセージを定義
				var errorMessage = {
					0: "原因不明のエラーが発生しました…。" ,
					1: "位置情報の取得が許可されませんでした…。" ,
					2: "電波状況などで位置情報が取得できませんでした…。" ,
					3: "位置情報の取得に時間がかかり過ぎてタイムアウトしました…。" ,
				};
				alert(errorMessage[error.code]);
			} ); 
		} else {
			alert("非対応です");
		}
	})
});
