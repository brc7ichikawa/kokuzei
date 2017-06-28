$(function(){
    $('#address_name').autocomplete({
        source: function( req, res ) {
            $.ajax({
                url: "/Search/ajaxAutoCompleteDataList/?address_name=" + encodeURIComponent(req.term),
                dataType: "json",
                success: function( data ) {
                    res(data);
                }
            });
        },
        autoFocus: true,
        delay: 100,
        minLength: 2
    });

		// 候補から検索
		$("a.list-group-item").each(function () {
			$(this).click(function () {
				$("#address_name").val($(this).html());
				$(form).submit();
			})
		})
  });
