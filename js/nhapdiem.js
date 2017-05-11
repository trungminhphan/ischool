function submit_nhapdiem(){
	var mamonhoc = $("#mamonhoc").val();
	$("#nhapdiemform").submit(function(){
		var value_return = true;
		if(mamonhoc=='THEDUC' || mamonhoc=='AMNHAC' || mamonhoc == 'MYTHUAT'){
			$(".marks").each(function(){
				_this = $(this);
				if(_this.val() != ''){
					if(_this.val() != 'Đ' && _this.val() != 'CĐ' && _this.val() != 'M'){
						_this.addClass("error_nhapdiem");
						value_return = false;
					}
				}
			});
		} else {
			$(".marks").each(function(){
				_this = $(this);
				if(_this.val() != ''){
					if($.isNumeric(_this.val())){
						if(parseFloat(_this.val()) < 0 || parseFloat(_this.val()) > 10){
							_this.addClass("error_nhapdiem");
							value_return = false;
						}
					} else {
						if(_this.val() != 'M'){
							_this.addClass("error_nhapdiem");
							value_return = false;	
						}
					}
				}
			});
		}
		return value_return;
	});
}
function marks_keyup(){
	var mamonhoc = $("#mamonhoc").val();
	$(".marks").keyup(function(){
		_this = $(this);
		if(_this.val() != ''){
			if(mamonhoc=='THEDUC' || mamonhoc=='AMNHAC' || mamonhoc == 'MYTHUAT'){
				if(_this.val() != 'Đ' && _this.val() != 'CĐ' && _this.val() != 'M'){
					_this.addClass("error_nhapdiem");
				} else {
						_this.removeClass("error_nhapdiem");
				}
			} else {
				if($.isNumeric(_this.val())){
					if(parseFloat(_this.val()) < 0 || parseFloat(_this.val()) > 10){
						_this.addClass("error_nhapdiem");
					} else {
						_this.removeClass("error_nhapdiem");
					}
				} else {
					if(_this.val() != 'M'){
						_this.addClass("error_nhapdiem");
					} else {
						_this.removeClass("error_nhapdiem");
					}
				}
			}
		} else {
			_this.removeClass("error_nhapdiem");
		}
	});
}

function marks_keydown(){
	$(".marks").keydown(function(e){
		//alert(e.which);
		var _this = $(this);
		var tabindex = parseInt(_this.attr("tabindex"));
		if(e.which == 39) {
			tabindex++; $('[tabindex="'+tabindex+'"]').focus();
			return false;
		} else if(e.which == 37){
			tabindex--; $('[tabindex="'+tabindex+'"]').focus();
			return false;
		} else if(e.which == 38){
			tabindex = tabindex - 15; $('[tabindex="'+tabindex+'"]').focus();
			return false;
		} else if(e.which == 40 || e.which == 13) {
			tabindex = tabindex + 15; $('[tabindex="'+tabindex+'"]').focus();
			return false;
		} else {
			$('[tabindex="'+tabindex+'"]').focus();
		}
	});
}

function fixed_header(){
	var tableOffset = $("#nhapdiem").offset().top;
	//var $header = $("#nhapdiem > thead").clone();
	//var $fixedHeader = $("#header-fixed").append($header);
	var $fixedHeader = $("#nhapdiem tfoot");

	$(window).bind("scroll", function() {
	    var offset = $(this).scrollTop();
	    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
	        $fixedHeader.show();
	    }
	    else if (offset < tableOffset) {
	        $fixedHeader.hide();
	    }
	});
}

function marks_focus(){
	$(".marks").focusin(function(){
		$(this).parents("tr").addClass("tr_focus");
	});
	$(".marks").focusout(function(){
		$(this).parents("tr").removeClass("tr_focus");
	});
}