$(function(){
	var optForSlick = {
		autoplay: false,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		dots: false,	
		speed: 1000
	};
	
	$('.slick').slick(optForSlick);
	
	time();
	
	if($(".fancybox").length){
		$(".fancybox").fancybox({
			padding: 20
		});
	}
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$('input[type=text][name=tel]').mask('+7 (999) 999 99 99', {placeholder: "-"});
	//$('input[type=text][name=passport]').mask('9999 999999', {placeholder: "-"});
	//$('input[type=text][name=private_number]').mask('h', {placeholder: "-"});
});

var timeend = new Date(2017, 9-1, 0, 0, 0);

function time() {
	var today 	= new Date();
	var today 	= Math.floor((timeend-today)/1000);
	var tsec		= today%60; today=Math.floor(today/60); 
	var tmin		= today%60; today=Math.floor(today/60);
	var thour	= today%24; today=Math.floor(today/24);
	
	if (today <= 0 && thour <= 0 && tmin <= 0 && tsec <= 0) {
		//$('#ad').hide();
		
	} else {
		if(tsec<10){
			tsec = '0'+tsec;	
		}
		if(tmin<10){
			tmin = '0'+tmin;	
		}
		if(thour<10){
			thour = '0'+thour;	
		}
		
		today = today.toString();
		thour = thour.toString();
		tmin = tmin.toString();
		tsec = tsec.toString();
		
		var $tdDays = $('#screen-counter-field').find('.counter-td-days');
		var $tdHours =  $('#screen-counter-field').find('.counter-td-hours');
		var $tdMinutes =  $('#screen-counter-field').find('.counter-td-minutes');
		
		$tdDays.empty();
		$tdHours.empty();
		$tdMinutes.empty();
		
		for(var i=0; i<today.length; i++){
			$tdDays.append('<div class="counter-item">'+today[i]+'</div>');
		}
		for(var i=0; i<thour.length; i++){
			$tdHours.append('<div class="counter-item">'+thour[i]+'</div>');
		}
		for(var i=0; i<tmin.length; i++){
			$tdMinutes.append('<div class="counter-item">'+tmin[i]+'</div>');
		}
		
		//console.log(today+' '+thour+':'+tmin+':'+tsec);
		window.setTimeout("time()", 60 * 1000);
	}
}
function registrationUser(obj){
	var $btn = $(obj);
	var $form = $btn.closest('form'); // выбрать форму именно так
	var $reset = $form.find('input[type=reset]');
	var $alertDanger = $form.find('.alert-danger');
	var $alertSuccess = $form.find('.alert-success');
	var request = $form.serialize();
	
	$alertDanger.empty().addClass('hide');
	$alertSuccess.empty().addClass('hide');
	
	$btn.prop('disabled', true);
	$.post('/registration.json', request, function(response){
		if(response.result){
			$alertSuccess.text(response.msg).removeClass('hide');
			$reset.click();
			
			setTimeout(function(){
				if($('#pop-up-login').css('display') === "block"){
					$('#pop-up-login').modal('hide');
				}
				if($('#pop-up-reg').css('display') === "block"){
					$('#pop-up-reg').modal('hide');
				}
				
			}, 10000);
		
		} else {
			var ar = response.msg.split('|');
			$alertDanger.html('<ul><li>'+ar.join('</li><li>')+'</li></ul>').removeClass('hide');
		}
		
		$btn.prop('disabled', false);
		
	}, 'json');
}
function login(obj){
	var $btn = $(obj);
	var $form = $('#form-login');
	var $reset = $form.find('input[type=reset]');
	var $alertDanger = $form.find('.alert-danger');
	var $alertSuccess = $form.find('.alert-success');
	var request = $form.serializeArray();
	
	$alertDanger.empty().addClass('hide');
	$alertSuccess.empty().addClass('hide');
	
	$btn.prop('disabled', true);
	$.post('/login.json', request, function(response){
		if(response.result){
			$alertSuccess.text('Вход успешно выполнен.').removeClass('hide');
			$reset.click();
			
			setTimeout(function(){
				$('#pop-up-login').modal('hide');
				window.location.href = '/profile';
			}, 1000);
		
		} else {
			var ar = response.msg.split('|');
			$alertDanger.html('<ul><li>'+ar.join('</li><li>')+'</li></ul>').removeClass('hide');
		}
		
		$btn.prop('disabled', false);
		
	}, 'json');
}
function addToCart(obj, product_id){
	var $btn = $(obj);
	var $form = $('#pop-up-tovar-added');
	var request = {
		id: product_id,
		'_csrf': $('meta[name="csrf-token"]').prop('content')
	};
	
	$btn.prop('disabled', true);
	$.post('/add-to-cart.json', request, function(response){
		if(response.result){
			$form.modal('show');
			
		} else {
			alert(response.msg);
		}
		
		$btn.prop('disabled', false);
		
	}, 'json');
}
function removeFromCart(obj, product_id){
	var $btn = $(obj);
	var $tr = $(obj).closest('tr');
	var request = {
		id: product_id,
		'_csrf': $('meta[name="csrf-token"]').prop('content')
	};
	
	$btn.prop('disabled', true);
	$.post('/remove-from-cart.json', request, function(response){
		if(response.result){
			$tr.fadeOut('fast', function(){
				// надо посчитать сколько осталось продуктов в корзине, если ни одного вида, то показать необходимую строчку
				$(this).remove();
				
				if($('.tbl-cart tbody tr').length === 0){
					$('#message-cart-empty').removeClass('hide');
					$('.tbl-cart').remove();
				}
			});
			$('#total_sum').text(response.msg);
			
		} else {
			alert(response.msg);
		}
		
		// $btn.prop('disabled', false);
	}, 'json');
}
function updateAmountCart(obj, product_id){
	var $input = $(obj);
	var $parent = $input.parent().parent();
	var $btn_minus = $parent.find('.btn-minus');
	var $btn_plus = $parent.find('.btn-plus');
	var $tr = $(obj).closest('tr');
	var $price_target_row = $tr.find('.tbl-cart-row-price');
	
	var cur_val = parseInt($.trim($input.val()));
	
	if(!isNaN(cur_val) && cur_val !== undefined){
		var request = {
			id: product_id,
			amount: cur_val,
			'_csrf': $('meta[name="csrf-token"]').prop('content')
		};
		
		$btn_minus.prop('disabled', true);
		$btn_plus.prop('disabled', true);
		$input.prop('disabled', true);
		
		$.post('/update-amount-cart.json', request, function(response){
			if(response.result){
				// обновить цены
				$('#total_sum').text(response.msg.total_sum);
				$price_target_row.text(response.msg.total_cur);
				
			} else {
				alert(response.msg);
			}

			$btn_minus.prop('disabled', false);
			$btn_plus.prop('disabled', false);
			$input.prop('disabled', false);
		}, 'json');
		
	} else {
		alert('неверное значение');
	}
}
function plusMinusAmountOnCart(obj){
	var $obj = $(obj);
	var $parent = $obj.parent().parent();
	var $btn_minus = $parent.find('.btn-minus');
	var $btn_plus = $parent.find('.btn-plus');
	var $input = $parent.find('input[type=text]');
	var cur_val = parseInt($.trim($input.val()));
	
	if(!isNaN(cur_val) && cur_val !== undefined){
		var new_val = $(obj).hasClass('btn-minus')? cur_val-1: cur_val+1;
		
		if(new_val === 0){
			new_val = 1;
		}
		
		$input.val(new_val);
		
		if(new_val !== cur_val){
			$input.change();
		}
		
	} else {
		alert('неверное значение');
	}
}
function setOrder(obj){
	var $obj = $(obj);
	var $form = $('#form-order');
	var $reset = $form.find('input[type=reset]');
	var $alertDanger = $form.find('.alert-danger');
	var $alertSuccess = $form.find('.alert-success'); 	
	
	$form.find('.alert').addClass('hide');
	
	$obj.prop('disabled', true);
	$.post('/add-order.json', $form.serialize(), function(response){
		if(response.result){
			$reset.click();
			alert('Заказ успешно оформлен, данные высланы на эл. почту.\nСейчас программа перенаправит Вас на платежную систему.');
			$('body').append(response.msg);
			// $alertSuccess.text().removeClass('hide');
			
		} else {
			var ar = response.msg.split('|');
			$alertDanger.html('<ul><li>'+ar.join('</li><li>')+'</li></ul>').removeClass('hide');
		}

		$obj.prop('disabled', false);
	}, 'json');
}
function file_input_onchange(obj){
	var $obj = $(obj);
	var $form = $obj.closest('form');
	var $submit = $form.find('button[type="submit"]');
	var img_name = $obj.val();
	
	if(img_name !== ""){
		$obj.parent().removeClass('btn-default').addClass('bg-info');
		$obj.parent().find('span').text(img_name);
		$submit.prop('disabled', false);
	
	} else {
		$submit.prop('disabled', true);
	}
}
function setOrderGiveGift(obj){
	var $obj = $(obj);
	var $form = $('#form-get-your-prize');
	var $reset = $form.find('input[type=reset]');
	var $alertDanger = $form.find('.alert-danger');
	var $alertSuccess = $form.find('.alert-success'); 	
	
	$form.find('.alert').addClass('hide');
	
	$obj.prop('disabled', true);
	$.post('/profile/create-order-on-get-gift.json', $form.serialize(), function(response){
		if(response.result){
			$reset.click();
			$alertSuccess.text(response.msg).removeClass('hide');
			
			setTimeout(function(){
				$alertSuccess.addClass('hide');
				$('#pop-up-get-your-prize').modal('hide');
			}, 3000);
			
		} else {
			var ar = response.msg.split('|');
			$alertDanger.html('<ul><li>'+ar.join('</li><li>')+'</li></ul>').removeClass('hide');
		}

		$obj.prop('disabled', false);
	}, 'json');
}