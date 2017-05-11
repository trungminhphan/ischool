function goi_ykien(){
	var dialog_ykien; var ykien;
	$(".ykien").click(function(){
		dialog_ykien = $("#dialog_ykien").data('dialog');
		ykien = $(this).attr("href");
		$("#ykien").val(ykien);$("#noidung").val('');$("#maxacnhanphuhuynh").val('');
		dialog_ykien.open();
	});
	$("#capnhat_ykien").click(function(){
		if($("#noidung").val() == ''){
			alert('Chưa nhập nội dung ý kiến'); return false;
		} else {
			$.ajax({
			    type: 'POST',
			    url: 'themykien.php',
			    data: $("#themykien").serialize(),
			    success: function(data){
			    	if(data == 'Failed'){
			    		alert('Mã xác nhận không đúng.');return false;
			    	} else {
			    		$("." + ykien + "_list").append(data);xoa_ykien();
			    		dialog_ykien.close();
			    	} 
				}
			});
			//dialog_ykien.close();
		}
	});

	$("#capnhat_ykien_no").click(function(){
		dialog_ykien.close();
	});

	$("#maxacnhanphuhuynh").keypress(function(e){
		$("#themykien").submit(function(){
			return false;
		});
	});
}

function xoa_ykien(){
	$(".xoaykien").click(function(){
		var dialog_xoaykien = $("#dialog_xoaykien").data('dialog');
		var link_xoaykien = $("#link_xoaykien");
		var _this = $(this);
		dialog_xoaykien.open();
		link_xoaykien.val($(this).attr("href"));
		$("#xoaykien_no").click(function(){
			dialog_xoaykien.close();
		});

		$("#xoaykien_ok").click(function(){
			$.get(link_xoaykien.val() + '&maxacnhan=' + $("#maxacnhanphuhuynh_del").val(), function(data){
				if(data=='Failed'){
					alert('Mã xác nhận không đúng');
				} else {
					_this.parents("li").remove();
					dialog_xoaykien.close();
				}
			});
			//alert(link_xoaykien.val() + '&maxacnhan='+$("#maxacnhanphuhuynh_del").val());
		});
	});
}