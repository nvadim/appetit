$(document).ready(function(){
	$('select[name="PAYMENT_TYPE"]').on('change',function(){
		if($(this).find('option:selected').attr('data-change') == 'Y'){
			$('.short_change').show();
		}else{
			$('.short_change').hide();
		}
	});
	$('[name="DELIVERY_TIME"]').mask('99:99',{placeholder: ' '})
	$('.time_type_toggle').on('click',function(e){
		e.preventDefault();
		$('.time_config').show();
		$(this).hide();
		$('[name="DELIVERY_TIME_TYPE"]').val(1);
		return false;
	})
	$('select[name="DISTRICT_ID"]').on('change',function(){
		calculateOrderSum();
	})
	$('.orders-line__send-mail').each(function(i,item) {
		var $id = $(this).closest('.orders-line').attr('data-order');
		var onS = function(e){
			$('#sms-accept-popover textarea').val('');
			$('#sms-accept-popover input[name="ORDER_ID"]').val($id);
			$('#sms-accept-popover input[name="PHONE"]').val($('.orders-line[data-order="'+$id+'"]').attr('data-phone'));
			$('#sms-accept-popover button').attr('disabled','disabled');
			$('.send-state').show();
			$('.sent-state').hide();
			$('.not-sent-state').hide();

		};
		$(item).webuiPopover({id_:$(item).attr('data-id'),url: '#'+$(item).attr('data-id'), cache: false,onShow: onS});
	});
	$('#sms-accept-popover select').on('change',function(){
		var $row = $('.orders-line[data-order="'+$('#sms-accept-popover input[name="ORDER_ID"]').val()+'"]');
		var text = $(this).find('option:selected').attr('data-template').replace('#NAME#',$row.attr('data-username'));
		text = text.replace('#PHONE#',$row.attr('data-phone'));
		text = text.replace('#ORDER_ID#',$row.attr('data-order'));
		text = text.replace('#SUM#',$row.attr('data-sum'));
		text = text.replace('#ADDRESS#',$row.attr('data-address'));
		text = text.replace('#ORDER_DATE#',$row.attr('data-order-date'));
		text = text.replace('#STATUS#',$row.attr('data-status'));
		$('#sms-accept-popover textarea').val(text);
		$('#sms-accept-popover button').removeAttr('disabled');
	});
	$('#sms-accept-popover textarea').on('change keyup',function(e){
		if($(this).val().length == 0){
			$('#sms-accept-popover button').attr('disabled','disabled');
		}else{
			$('#sms-accept-popover button').removeAttr('disabled');
		}
	});
	$('#sms-accept-popover button').on('click',function (e) {
		$.ajax({
			url: '/crm/',
			method: 'POST',
			dataType: 'json',
			data: {action: 'sendSms',PHONE: $('#sms-accept-popover input[name="PHONE"]').val(), TEMPLATE: $('#sms-accept-popover textarea').last().val()},
			success: function(data){
				$('.send-state').hide();
				if(data.status == 1){
					$('.sent-state').show();
					$('#popover-sms-accept-popover').css('top','310px');
					$('#popover-sms-accept-popover .webui-arrow').css('top','20px');
				}else{
					$('.not-sent-state').show();
				}
			}
		})
	})
	if(window.location.hash.indexOf('#order') !== -1){
		var order_id = window.location.hash.split('-')[1];
		viewOrder(order_id);
	}
	if(window.location.hash.indexOf('#client') !== -1){
		var user_id = window.location.hash.split('-')[1];
		viewUser(user_id);
	}
	alertify.set('notifier','position', 'top-left');
	alertify.set('notifier','delay', 1);
	$('.notify-config input[type="checkbox"]').on('change',function(){
		if($(this).is(':checked')){
			$('[name="'+$(this).data('target')+'"]').val(1);
		}else{
			$('[name="'+$(this).data('target')+'"]').val(0);
		}
	})
	$('.save-user-data').on('click',function(){
		$.ajax({
			url: '/crm/clients/',
			method: 'post',
			data: {
				action:'updateUser',
				ID: window.view_user,
				NAME: $('.client-preview input[name="NAME"]').val(),
				PHONE: $('.client-preview input[name="PHONE"]').val(),
				EMAIL: $('.client-preview input[name="EMAIL"]').val(),
				BIRTHDAY: $('.client-preview input[name="BIRTHDAY"]').val(),
				NOTIFY_EMAIL: $('.client-preview input[name="NOTIFY_EMAIL"]').val(),
				NOTIFY_SMS: $('.client-preview input[name="NOTIFY_SMS"]').val(),
			},
			dataType: 'json',
			success: function(data){
				if(data.status == 1){
					alertify.success("Информация обновлена");
				}else{
					alertify.error("Ошибка при сохранении пользователя");
				}
			}
		})
	});
    $('.save-order-data').on('click',function(e){
        e.preventDefault();
        $.ajax({
            url: '/crm/?action=updateOrder',
            data: $('#order_form').serialize(),
            method: 'post',
            dataType: 'json',
            success: function(data){
				if(data.status == 1){
					alertify.success("Информация обновлена");
					if($('[name="STATUS"]').val()==7 || $('[name="STATUS"]').val()==2){
						$('.save-order-data').hide()
					}
				}else{
					alertify.error("Ошибка при сохранении заказа");
				}
            }
        })
    })
	$('.bd-input input,.bd-input textarea').off('focus').on('focus',function(){
		if($(this).attr('name') == 'PHONE' || $(this).attr('name') == 'USER[PHONE]' || $(this).attr('name') == 'ORDER[USER_PHONE]'){
			var focusText = $(this).val() || '+7';
			$(this).val(focusText);
		}
		var $cont = $(this).parents('.bd-input');
		$cont.addClass('focused').removeClass('error ok');;
		$cont.removeClass('filled');
		if($cont.closest('.input-row')){
			$cont.closest('.input-row').css('margin-top',0);
		}
		if($cont.closest('.input-row-last')){
			$cont.closest('.input-row-last').css('margin-top',0);
		}
	});
	$('.bd-input input,.bd-input textarea').off('blur').on('blur',function(){
		var $cont = $(this).parents('.bd-input');
		$cont.removeClass('focused');
		if($(this).val().trim().length>0){
			$cont.addClass('filled')
		}else{
			$cont.removeClass('filled');
		}
	});
	$('.close-window').on('click',function(){
		$(this).closest('[class*="-preview"]').hide();
		var has_modal = 0;
		if($('.order-preview').is(':visible')){
			window.location.hash = '#order-'+$('.order-preview .order_num_value').text();
			$('.order-preview').css('opacity','1');
			$('.order-preview').css('position','absolute');
			has_modal = 1;
		}
		if($('.client-preview').is(':visible')){
			window.location.hash = '#client-'+$('.customer-information__client-head .num a').text();
			$('.client-preview').css('opacity','1');
			$('.client-preview').css('position','absolute');
			has_modal = 1
		}
		if(!has_modal){
			window.location.hash = '';
			$('.wrapper').first().css('opacity',1);
		}
	});
	if ($('input[type="checkbox"]').length) {
		$('input[type="checkbox"]').uniform();
	}
	$(".basic").selectOrDie();
	$('.delivery-select').on('click', '.delivery-select__item:not(.active)', function() {
		$('[name="DELIVERY_TYPE"]').val($(this).attr('data-type'));
	    $(this).addClass('active').siblings().removeClass('active');
	    $(this).closest('.customer-information__delivery').find('.delivery-options').removeClass('active').eq($(this).index()).addClass('active');
	});
	$('.data-client-info__vip-icon').on('click',function(){
		$.ajax({
			url: '/crm/clients/',
			method: 'POST',
			dataType: 'json',
			data: {action: 'setVip',id: window.view_user},
			success: function(data){
				if(data.status==1){
					$('.data-client-info__vip-icon').addClass('active');
				}else{
					$('.data-client-info__vip-icon').removeClass('active');
				}
			}
		})
	});
	$('.date-filter input').on('change',function(){
		if($('.date-filter input[name="date_start"]').val().length > 0 && $('.date-filter input[name="date_end"]').val().length > 0){
			$('.date-filter .apply-filter').removeAttr('disabled').removeClass('disabled');
		}else{
			$('.date-filter .apply-filter').attr('disabled','disabled').addClass('disabled');
		}
	})
});
function masking(){
	$('.client-preview input[name="PHONE"], input[name="USER_PHONE"]').mask(window.phone_mask,{});
	$('.client-preview input[name="BIRTHDAY"]').mask('99.99.9999',{});
}
function renderOrderLine(data){
	var sms_popover = 'sms-decline-popover';
	var sms_class = 'send-mail-disable';
	if(data.SEND_SMS == 1){
		sms_popover = 'sms-accept-popover';
		sms_class = 'send-mail-active';
	}
	var sms_icon = '';
	var card_additional_class ='sms_disabled';
	if(window.has_sms == 1){
		sms_icon = '<div data-id="'+sms_popover+'" data-placement="left" data-handler="popover" class="orders-line__send-mail '+sms_class+'"><span></span></div> ';
		card_additional_class = '';
	}
	$('.orders-list').prepend('<div class="orders-line order-status-'+data.STATUS+'" data-order="'+data.ID+'" data-username="'+data.USER_NAME+'" data-phone="'+data.USER_PHONE+'" data-sum="'+data.ORDER_SUM+'" data-address="ул. '+data.STREET+', д.'+data.HOUSE+', кв. '+data.APARTMENT+'" data-order-date="'+data.ORDER_DATE_F+'" data-status="Новый"> ' +
		'<div onclick="viewUser('+data.USER_ID+')" class="orders-line__num user'+data.USER_ID+'"><span></span><a href="#client-'+data.USER_ID+'">'+data.ID+'</a></div>' +
		 sms_icon+
		'<div class="orders-line__show-card '+card_additional_class+'" onclick="viewOrder('+data.ID+');">Просмотр</div> ' +
		'<div class="orders-line__info"> ' +
		'<div class="orders-line__status orders-line__status--'+data.STATUS+'">Новый</div>' +
		'<div class="orders-line__about-out">' +
		'<div class="orders-line__about"> ' +
		'<div class="orders-line__date"> ' +
		'<div class="title">Дата</div> ' +
		'<p>'+data.ORDER_DATE_F+'</p> ' +
		'</div> ' +
		'<div class="orders-line__name"> ' +
		'<div class="title">Имя</div> ' +
		'<p>'+data.USER_NAME+'</p> ' +
		'</div> ' +
		'<div class="orders-line__phone">' +
		'<div class="title">Телефон</div> ' +
		'<p>'+data.USER_PHONE+'</p> ' +
		'</div> ' +
		'<div class="orders-line__summa"> ' +
		'<div class="title">Сумма</div> ' +
		'<p><span>'+number_format(data.ORDER_SUM, 0, '.', ' ')+'</span><span class="currency">'+window.currency_f+'</span></p></div> </div> </div> </div></div>');
}
function getCatSelectHtml(id){
	var catSelectContent = '';
	for (var index in window.product_categories) {
		var selected = '';
		if(index == id)
			selected = 'selected="selected"';
		catSelectContent += '<option '+selected+' value="'+index+'">'+window.product_categories[index].name+'</option>';
	}
	return catSelectContent;
}
function getProductsForSection(section, product){
	var result = ''
	for (var index in window.product_categories[section].products) {
		var selected = '';
		if(index == product)
			selected = 'selected="selected"';
		result += '<option data-price="'+window.product_categories[section].products[index].price+'" data-nosale="'+window.product_categories[section].products[index].no_sale+'" '+selected+' value="'+index+'">'+window.product_categories[section].products[index].name+'</option>';
	}
	return result;
}
function createProduct(){
	var new_index = parseInt($('.order-preview .order-list__line').last().attr('data-index'))+1;
	var productItem =  '<div class="product_config_cont"><input type="hidden" name="BASKET_CONTENT['+new_index+'][PRODUCT_ID]" value="0" /><input type="hidden" name="BASKET_CONTENT['+new_index+'][ID]" class="item_id" value="0" /></div><div data-index="'+new_index+'"  data-price="0" class="order-list__line row"><div class="edit-cont" style="display: block;">' +
		'<div class="order-list__categor"><select class="basic product_categories_" >'+getCatSelectHtml(Object.keys(window.product_categories)[0])+'</select></div>';
	productItem += '<div class="order-list__product index-'+new_index+'"><div class="order-list__product-select"><select class="basic products_">'+getProductsForSection(Object.keys(window.product_categories)[0],null)+'</select></div></div></div>' ;


	productItem += '<div class="order-list__kvo"> <div class="colich_tov"> <input type="button" value="-" class="minus_tov" /> <input type="text" name="BASKET_CONTENT['+new_index+'][AMOUNT]" value="1" class="txt_col_tov" /> <input type="button" value="+" class="plus_tov" /> </div> </div><div class="order-list__price"><span>0</span> <span class="currency">'+window.currency_f+'</span></div><div class="order-list__edit"></div><div class="order-list__delete"></div>'
	productItem += '</div>'

	$('.order-list__content').append(productItem);
	$('.order-list__content .order-list__line[data-index="'+new_index+'"] select').selectOrDie();
	registerOrderProductItemListeners();

	$('.order-list__content .order-list__line[data-index="'+new_index+'"] select').last().trigger('change');

}
function getProductOptions(section,prod,options,i){

	var resp = '<div class="row">';
	for (var index_ in options){

	    if(window.product_categories[section].products[prod].options[index_]){
            resp += '<div class="order-list__properties"><select data-placeholder-option="true" name="BASKET_CONTENT['+i+'][OPTIONS][OPTION_'+index_+']" class="basic prod_option option_'+index_+'">';
            var selected = '';
			resp += '<option value="null">'+window.product_categories[section].products[prod].options[index_][0].PROP+'</option>';
            for (var index in window.product_categories[section].products[prod].options[index_]) {

                if(parseInt(options[index_]) == parseInt(window.product_categories[section].products[prod].options[index_][index].INDEX))
                    selected = 'selected="selected"';

                resp+= '<option '+selected+' value="'+index+'" data-price="'+window.product_categories[section].products[prod].options[index_][index].PRICE+'" data-old-price="'+window.product_categories[section].products[prod].options[index_][index].OLD_PRICE+'" data-weight="'+window.product_categories[section].products[prod].options[index_][index].WEIGHT+'">'+window.product_categories[section].products[prod].options[index_][index].VALUE+'</option>';
            }
            resp += '</select></div>';
        }
	}
	resp += '</div>';

	return resp;
}
function viewOrder(id){
	if(window.new_orders!==undefined && window.new_orders > 0)
		window.new_orders--;
		
	

	$('.wrapper').first().css('opacity',0);
	$('.order-preview .spinner').show();
	$('.order-preview .wrap').css('opacity',0);
	$('.order-preview').css('opacity','1');
	$('.order-preview').css('position','absolute');

	if($('.client-preview').is(':visible')){
		$('.order-preview').css('z-index',3);
		$('.client-preview').css('z-index',2);
		$('.client-preview').css('opacity','0');
		$('.client-preview').css('position','fixed');
	}
	window.location.hash = '#order-'+id;
	$('.order-list__content').html('');
	$.ajax({
		url: '/crm/',
		method: 'POST',
		dataType: 'json',
		data: {action: 'getOrder',id: id},
		success: function(data){
			window.currentPercent = data.PERCENT;
			if(data.PERCENT == 0){
				$('.bonuses_append').hide();
			}else{
				$('.bonuses_append').show();
			}
			$('[name="BONUSES_APPEND"]').val(data.BONUSES_APPEND);
			$('.bonuses_append span').first().text(data.BONUSES_APPEND);
			$('.payment-status').hide();
			$('.print-bt').attr('href','/crm/print.php?id='+id);
			if(data.DELIVERY_TYPE==2){
				$('.delivery-select__item.himself').trigger('click');
			}else{
				$('.delivery-select__item.courier').trigger('click');
			}
			$('[name="DELIVERY_TIME_TYPE"]').val(data.DELIVERY_TIME_TYPE);
			if(data.DELIVERY_TIME_TYPE == 0){
				$('.time_config').hide();
				$('.time_type_toggle').show();
			}else{
				$('.time_type_toggle').hide();
				$('[name="DELIVERY_TIME"]').val(data.DELIVERY_TIME).parent().addClass('filled');
				$('[name="DELIVERY_TIME"]').val(data.DELIVERY_TIME).parent().addClass('filled');
				$('[name="DELIVERY_DATE"]').find('option[data-valued="'+data.DELIVERY_DATE+'"]').attr('selected','selected').parent().selectOrDie('update');
				$('.time_config').show();
			}
			$('.customer-information__status').attr('class','customer-information__status').addClass('customer-information__status--'+data.STATUS);
			if(data.USER_ID!=0){
				$('.customer-information__client-head .num a').attr('href','#client-'+data.USER_ID).attr('onclick','viewUser('+data.USER_ID+')').text(data.USER_ID).parent().show();
			}else{
				$('.customer-information__client-head .num').hide();
			}
			$('.order_num_value').text(data.ID);
			$('.order-num .date').text(data.FORMATED_DATE);
			$('[name="ID"]').val(data.ID);
			$('[name="USER_ID"]').val(data.USER_ID);
			$('[name="ORDER_SUM"]').val(data.ORDER_SUM);
			$('[name="DELIVERY_PRICE"]').val(data.DELIVERY_PRICE);
			$('.customer-information__status').text(data.STATUS_NAME);
			$('.source-order span').text(data.SOURCE);
			$('[name="STATUS"]').val(data.STATUS).selectOrDie('update');
			if(data.STATUS == 7 || data.STATUS == 2){
				$('.save-order-data').hide()
			}else{
				$('.save-order-data').show()
			}
			var sum = data.ORDER_SUM - data.DELIVERY_PRICE - data.DISCOUNT_BONUSES;
			if(sum < 0)
				sum = 0;
			$('.order_sum_value span').first().text(sum);
			$('.delivery_price_value span').first().text(data.DELIVERY_PRICE);
			$('.promo_code_discount_value span').first().text(data.DISCOUNT+'%');
			if( data.DISCOUNT_BONUSES > 0){
				$('.bonuses_used_value').show();
				$('.bonuses_used_value span').first().text(data.DISCOUNT_BONUSES);
			}else{
				$('.bonuses_used_value').hide();
			}
			$('.itogo span').first().text(data.ORDER_SUM);

			$('[name="DELIVERY_TYPE"]').val(data.DELIVERY_TYPE);

			$('[name="USER_NAME"]').val(data.USER_NAME).parent().addClass('filled');
			$('[name="USER_PHONE"]').val(data.USER_PHONE).parent().addClass('filled');
			$('select[name="PAYMENT_TYPE"]').val(data.PAYMENT_TYPE).trigger('change').selectOrDie('update');
			if(data.DISTRICT_ID!=undefined && data.DISTRICT_ID!=null){
				$('select[name="DISTRICT_ID"]').val(data.DISTRICT_ID).selectOrDie('update');
			}
			if(data.DELIVERY_PICKUP_ID!=undefined && data.DELIVERY_PICKUP_ID!=null){
				$('select[name="DELIVERY_PICKUP_ID"]').val(data.DELIVERY_PICKUP_ID).selectOrDie('update');
			}
			if(data.ONLINE_PAY_SIGNATURE != ''){

				if(data.ONLINE_PAY_STATUS == 1){
					$('.payment-status.paid').show();
				}else{
					$('.payment-status.not-paid').show();
				}
			}else{
				$('.payment-status').hide();
			}
			$('[name="DISCOUNT"]').val(0);
			$('[name="DISCOUNT_BONUSES"]').val(0);
			if(data.DISCOUNT !==0 ){
				$('[name="DISCOUNT"]').val(data.DISCOUNT);
			}
			if(data.DISCOUNT_BONUSES !==0 ){
				$('[name="DISCOUNT_BONUSES"]').val(data.DISCOUNT_BONUSES);
			}
			$('.pickup_discount').hide();
			if(data.DISCOUNT_PICKUP != 0 ){
				$('.pickup_discount span').first().text(data.DISCOUNT_PICKUP).parent().parent().show();
				$('[name="DISCOUNT"]').val(data.DISCOUNT_PICKUP);
			}

			$('[name="STREET"]').val(data.STREET).parent().addClass('filled');
			$('[name="HOUSE"]').val(data.HOUSE).parent().addClass('filled');
			$('[name="APARTMENT"]').val(data.APARTMENT).parent().addClass('filled');
			$('[name="COMMENT"]').val(data.COMMENT).parent().addClass('filled');
			if(data.ODD_MONEY!=undefined) {
				$('[name="ODD_MONEY"]').val(data.ODD_MONEY).parent().addClass('filled');
			}
			if(data.PROMO_CODE!=undefined && data.PROMO_CODE!=null && data.PROMO_CODE.length>0){
				$('.promo_code_discount_value').show();
				$('.customer-information__promokod').show();
				$('[name="PROMO_CODE"]').val(data.PROMO_CODE).parent().addClass('filled').show();
			}else{
				$('.promo_code_discount_value').hide();
				$('.customer-information__promokod').hide();
				$('[name="PROMO_CODE"]').val('').parent().hide();
			}

			$.each(data.BASKET_CONTENT.products,function(i,item){

				if(item.ID != undefined ){
					var id_ = item.ID;
					var options_selects = '';
					var option_view = '';
                    var product_config =  '<div class="product_config_cont"><input type="hidden" name="BASKET_CONTENT['+i+'][PRODUCT_ID]" value="'+item.ID+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][ID]" class="item_id" value="'+item.ID+'" />';

                    if(item.ID.indexOf('additional')!==-1){
                        product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][TYPE]" value="additional"><input type="hidden" name="BASKET_CONTENT['+i+'][IS_ADDITIONAL]" value="1" /><input type="hidden" name="BASKET_CONTENT['+i+'][ADDITIONAL_ID]" value="'+item.ID.split('_')[1]+'" />';
                    }
                    if(item.ID.indexOf('gift')!==-1){
                        product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][TYPE]" value="gift"><input type="hidden" name="BASKET_CONTENT['+i+'][IS_GIFT]" value="1" /><input type="hidden" name="BASKET_CONTENT['+i+'][GIFT_ID]" value="'+item.GIFT_ID+'" />';
                    }
                    if(item.ID.indexOf('promo')!==-1){
                        product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][TYPE]" value="promo"><input type="hidden" name="BASKET_CONTENT['+i+'][IS_PROMO]" value="1" /><input type="hidden" name="BASKET_CONTENT['+i+'][PROMO_ID]" value="'+item.PRODUCT_ID+'" />';
                    }

                    if(item.ID.indexOf('constructor')!==-1){
                        product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][IS_CONSTRUCTOR]" value="1" /><input type="hidden" name="BASKET_CONTENT['+i+'][ID]" value="constructor" /><input type="hidden" name="BASKET_CONTENT['+i+'][PRODUCT_ID]" value="constructor" /><input type="hidden" name="BASKET_CONTENT['+i+'][NAME]" value="'+item.NAME+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][PRICE]" value="'+item.PRICE+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][WEIGHT]" value="'+item.WEIGHT+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][IMAGE]" value="'+item.IMAGE+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][BASE_ID]" value="'+item.BASE_ID+'" /><input type="hidden" name="BASKET_CONTENT['+i+'][SOUSE_ID]" value="'+item.SOUSE_ID+'" />';

                        $.each(item.INGREDIENTS,function(ji,jitem){
                            product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][INGREDIENTS][]" value="'+jitem+'" />';
                        });
                        $.each(item.ING_AMOUNT,function(ji,jitem){
                            product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][ING_AMOUNT][]" value="'+jitem+'" />';
                        });
                    }
                    product_config += '</div>';
					if(item.OPTIONS!==undefined && item.OPTIONS['1']!==null && window.product_categories[item.SECTION_ID].products[id_] != undefined && window.product_categories[item.SECTION_ID].products[id_].options[1][item.OPTIONS['1']] !== undefined){
						var options = {};
                       // product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][OPTIONS][OPTION_1]" value="'+item.OPTIONS['1']+'" />';
						option_view += '<div class="options_view">' +
							'<div class="option-el option_1">'+
							'<div class="op_name">'+window.product_categories[item.SECTION_ID].products[id_].options[1][0].PROP+'</div>'+
							'<div class="op_value">'+window.product_categories[item.SECTION_ID].products[id_].options[1][item.OPTIONS['1']].VALUE+'</div>'+
							'</div>';
						options['1'] = item.OPTIONS['1'];
						if(item.OPTIONS['2']!==null && window.product_categories[item.SECTION_ID].products[id_].options[2][0]!==undefined){
                            //product_config += '<input type="hidden" name="BASKET_CONTENT['+i+'][OPTIONS][OPTION_2]" value="'+item.OPTIONS['2']+'" />';
							options['2'] = item.OPTIONS['2'];
							option_view += '' +
								'<div class="option-el option_2">'+
								'<div class="op_name">'+window.product_categories[item.SECTION_ID].products[id_].options[2][0].PROP+'</div>'+
								'<div class="op_value">'+window.product_categories[item.SECTION_ID].products[id_].options[2][item.OPTIONS['2']].VALUE+'</div>'+
								'</div>';
						}

						option_view += '</div>';

						options_selects = getProductOptions(item.SECTION_ID,id_,options,i);

					}
					if((item.ID.indexOf('additional_')!=-1 || item.ID.indexOf('gift_')!=-1)){
						id_ = item.ID.split('_')[1];
					}
					if(item.IS_CONSTRUCTOR !== undefined){
						option_view += '<div class="options_view">' +
							'<div class="option-el option_1">'+
							'<div class="op_name">Основа</div>'+
							'<div class="op_value">'+item.BASE_NAME+'</div>' +
							'<div class="op_name op_name_2">Соус</div>'+
							'<div class="op_value">'+item.SOUSE_NAME+'</div>'+
							'</div>';
						option_view += '<div class="option-el option_2"><div class="op_name">Начинка</div>';
						$.each(item.INGREDIENTS_NAME,function(i_,item_){
							option_view +='<div class="op_value">'+item_+'</div>';
						});
						option_view += '</div>';
					}
					var productItem = product_config+'<div data-index="'+i+'"  data-price="'+item.PRICE+'" class="order-list__line row '+item.APPEND_WITHOUT_SALE+' '+item.CLASSES+' prod_'+item.ID+'">' +'<div class="view-cont_"><div class="product-image"><img src="'+item.IMAGE+'"></div>' +
						'<div class="name-cont">' +
						'<div class="name">'+item.NAME+'</div><div class="section">'+item.SECTION+'</div>'
						+ option_view +
						'</div></div>';
					if(item.IS_CONSTRUCTOR == undefined && item.ID !== 'promo'){
					    var name_ = '';
                        if(item.IS_ADDITIONAL == undefined){
                            name_ = ' name="BASKET_CONTENT['+i+'][SECTION_ID]" ';
                        }
						productItem +=  '<div class="edit-cont" style="display: none;">' +
						'<div class="order-list__categor"><select '+name_+' class="basic product_categories_" >'+getCatSelectHtml(item.SECTION_ID)+'</select></div>';
						productItem += '<div class="order-list__product index-'+item.INDEX+'"><div class="order-list__product-select"><select class="basic products_">'+getProductsForSection(item.SECTION_ID,id_)+'</select>'+options_selects+'</div></div></div>' ;
					}else{

					}

					productItem += '<div class="order-list__kvo"> <div class="colich_tov"> <input type="button" value="-" class="minus_tov" /> <input type="text" name="BASKET_CONTENT['+i+'][AMOUNT]" value="'+item.AMOUNT+'" class="txt_col_tov" /> <input type="button" value="+" class="plus_tov" /> </div> </div><div class="order-list__price"><span>'+item.LOCAL_SUM+'</span> <span class="currency">'+window.currency_f+'</span></div><div class="order-list__edit"></div><div class="order-list__delete"></div>'
					productItem += '</div>'

					$('.order-list__content').append(productItem);
					if(item.OPTIONS!==undefined && item.OPTIONS['1']!==null){
						$('.order-preview .prod_'+item.ID).find('.option_1').val(item.OPTIONS['1']);
						if(item.OPTIONS['2']!==null){
							$('.order-preview .prod_'+item.ID).find('.option_2').val(item.OPTIONS['2']);
						}
					}
					$('.order-list__content select').selectOrDie();

				}
			});
			masking();
			registerOrderProductItemListeners();
			calculateOrderSum();
			$('.order-preview .spinner').hide();
			$('.order-preview .wrap').css('opacity',1);
		}
	});
	$('.order-preview').show();
	return false;
}
function registerOrderProductItemListeners(){
	$('.order-list__line .prod_option').off().on('change',function(){
		var $product = $(this).closest('.order-list__line');

		var mode = 1;
		if($product.find('.prod_option').length == 2){
			mode = 2;
		}
		var new_price, new_old_price, new_weight;


		new_price = parseInt($product.find('.prod_option').first().find('option:selected').data('price'));
		new_old_price = parseInt($product.find('.prod_option').first().find('option:selected').data('old-price'));
		new_weight = parseInt($product.find('.prod_option').first().find('option:selected').data('weight'));

		if(mode==2){
			new_price += parseInt($product.find('.prod_option').last().find('option:selected').data('price'));
			if(!isNaN(parseInt($product.find('.prod_option').last().find('option:selected').data('old-price'))))
				new_old_price += parseInt($product.find('.prod_option').last().find('option:selected').data('old-price'));
			new_weight += parseInt($product.find('.prod_option').last().find('option:selected').data('weight'));
		}

		if(!isNaN(new_price)){
			$product.attr('data-price',new_price);
		}
		var new_sum = number_format($product.find('.txt_col_tov').val()*new_price, 0, '.', ' ');
		if(new_sum != 0)
			$(this).closest('.order-list__line').find('.order-list__price span').first().text(new_sum);
		calculateOrderSum();
		$product.find('.prod_option').selectOrDie('update');

	});
    $('.order-list__line .products_').off().on('change',function(){
        $(this).closest('.order-list__line').attr('data-price',$(this).find('option:selected').data('price'));
        $(this).closest('.order-list__line').removeClass('without_sale')
        if($(this).find('option:selected').data('nosale') == 'Y'){
	    	$(this).closest('.order-list__line').addClass('without_sale')
        }
		var is_custom = 0;
		if($(this).closest('.order-list__line').prev().find('.additional_id_input').length){
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][PRODUCT_ID]"]').val('additional_'+$(this).val());
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][ID]"]').val('additional_'+$(this).val());
			$(this).closest('.order-list__line').prev().find('.additional_id_input').val($(this).val());
			is_custom = 1;
		}

		if($(this).closest('.order-list__line').prev().find('.gift_id_input').length){
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][PRODUCT_ID]"]').val('gift');
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][ID]"]').val('gift');
			$(this).closest('.order-list__line').prev().find('.gift_id_input').val($(this).val());
			is_custom = 1;
		}
        $(this).closest('.order-list__line').find('.order-list__price span').first().text(
            number_format(parseInt($(this).find('option:selected').data('price'))*parseInt($(this).closest('.order-list__line').find('.txt_col_tov').val()), 0, '.', ' ')
        );
		if(is_custom == 0){
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][PRODUCT_ID]"]').val($(this).val());
			$(this).closest('.order-list__line').prev().find('[name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][ID]"]').val($(this).val());
			//$(this).closest('.order-list__line').prev()().val($(this).val());
		}

        calculateOrderSum();

        var options_selects = getProductOptions($(this).closest('.order-list__line').find('.product_categories_').val(),$(this).val(),{'1':null,'2':null},$(this).closest('.order-list__line').attr('data-index'));
        if(options_selects){
            $(this).closest('.order-list__line').find('.order-list__product-select .row').remove();
            $(this).closest('.order-list__line').find('.edit-cont .order-list__product-select').append(options_selects);
            $(this).closest('.order-list__line').find('.edit-cont').find('select').selectOrDie();
            registerOrderProductItemListeners();
        }
        $(this).closest('.order-list__line').find('.edit-cont').find('select').selectOrDie('update');
    });
	$('.order-list__delete').off().on('click',function(e){

		$(this).closest('.order-list__line').prev().remove();
		$(this).closest('.order-list__line').remove();
		calculateOrderSum();
	})
	$('.order-list__edit').off().on('click',function(e){
		$(this).closest('.order-list__line').find('.view-cont_').hide();
		$(this).closest('.order-list__line').find('.edit-cont').show();
	});
	$('.minus_tov').off().on('click',function(e){
		var minus_tov = $(this).next('.txt_col_tov');
		var minus_tov_val = minus_tov.val();
		if (minus_tov_val>1) {
			minus_tov_val--;
			minus_tov.val(minus_tov_val);
		}
		var new_sum = number_format(minus_tov_val*parseInt($(this).closest('.order-list__line').attr('data-price')), 0, '.', ' ');
		$(this).closest('.order-list__line').find('.order-list__price span').first().text(new_sum);
		calculateOrderSum();
		e.preventDefault();
	});
	$('.plus_tov').off().on('click',function(e){
		var plus_tov = $(this).prev('.txt_col_tov');
		var plus_tov_val = plus_tov.val();
		plus_tov_val++;
		plus_tov.val(plus_tov_val);
		var new_sum = number_format(plus_tov_val*parseInt($(this).closest('.order-list__line').attr('data-price')), 0, '.', ' ');
		$(this).closest('.order-list__line').find('.order-list__price span').first().text(new_sum);
		calculateOrderSum();
		e.preventDefault();
	});
	$('.product_categories_').off().on('change',function(){
		$(this).closest('.order-list__line').find('.products_').html(getProductsForSection($(this).val(),0)).selectOrDie('update');
		if($(this).val() == 'additional'){
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][IS_ADDITIONAL]" value="1"  class="additional_id_input_h">');
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][ADDITIONAL_ID]" value="" class="additional_id_input">');
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][TYPE]" value="additional" class="additional_id_input_type">');
		}else{
			$(this).closest('.order-list__line').prev().find('.additional_id_input').remove();
			$(this).closest('.order-list__line').prev().find('.additional_id_input_h').remove();
			$(this).closest('.order-list__line').prev().find('.additional_id_input_type').remove();
		}
		if($(this).val() == 'gifts'){
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][IS_GIFT]" value="1"  class="gift_id_input_h">');
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][GIFT_ID]" value="" class="gift_id_input">');
			$(this).closest('.order-list__line').prev().append('<input type="hidden" name="BASKET_CONTENT['+$(this).closest('.order-list__line').attr('data-index')+'][TYPE]" value="gift" class="gift_id_input_type">');
		}else{
			$(this).closest('.order-list__line').prev().find('.gift_id_input').remove();
			$(this).closest('.order-list__line').prev().find('.gift_id_input_h').remove();
			$(this).closest('.order-list__line').prev().find('.gift_id_input_type').remove();
		}
		$(this).selectOrDie('update');
		$(this).closest('.order-list__line').find('.products_').trigger('change');
	})
}
function calculateOrderSum(){
	var sum = 0;
	var sum_for_b = 0;
	$('.order-preview .order-list__line').each(function (i, item) {
		sum += $(item).attr('data-price')*parseInt($(item).find('.txt_col_tov').val());
		
		if(!$(item).hasClass('without_sale')){
			sum_for_b += $(item).attr('data-price')*parseInt($(item).find('.txt_col_tov').val());
		}
	});
	if(window.notAppendBonusesWithPromo && $('[name="PROMO_CODE"]').val().length > 0){
		sum_for_b = 0;
	}
	console.log(sum_for_b)

	var delivery_price = $('[name="DISTRICT_ID"] option:selected').data('price');
	if(sum >= parseInt($('[name="DISTRICT_ID"] option:selected').data('free')))
		delivery_price = 0;
		
	
	var bonuses_append = parseInt((sum_for_b - parseInt($('[name="DISCOUNT_BONUSES"]').val()))*window.currentPercent/100);
    $('[name="ORDER_SUM"]').val(sum);
    $('[name="BONUSES_APPEND"]').val(bonuses_append);
    $('[name="DELIVERY_PRICE"]').val(delivery_price);
	$('.order_sum_value span').first().text(number_format(sum, 0, '.', ' '))
	$('.bonuses_append span').first().text(number_format(bonuses_append, 0, '.', ' '))
	$('.delivery_price_value span').first().text(number_format(delivery_price, 0, '.', ' '));
	$('.itogo span').first().text(number_format(sum+delivery_price  - (sum*parseInt($('[name="DISCOUNT"]').val())/100) - parseInt($('[name="DISCOUNT_BONUSES"]').val()), 0, '.', ' '));
}
function viewUser(id) {
	if(id==0) return false;
	$('.wrapper').first().css('opacity',0);
	$('.client-preview').show();
	$('.client-preview').css('opacity','1');
	$('.client-preview').css('position','absolute');
	$('.client-preview .spinner').show();
	$('.client-preview .wrap').css('opacity',0);
	window.location.hash = '#client-'+id;
	if($('.order-preview').is(':visible')){
		$('.order-preview').css('z-index',2);
		$('.client-preview').css('z-index',3);
		$('.order-preview').css('opacity','0');
		$('.order-preview').css('position','fixed');
	}
	$.template( "addressTemplate", '<div class="client-shot-address__line row"> ' +
		'<div class="client-shot-address__name"> ' +
		'<div class="title">Название</div> ' +
		'<p>${NAME}</p> ' +
		'</div> ' +
		'<div class="client-shot-address__street"> ' +
		'<div class="title">Улица</div> ' +
		'<p>${STREET}</p> ' +
		'</div> ' +
		'<div class="client-shot-address__house"> ' +
		'<div class="title">Дом</div> ' +
		'<p>${HOUSE}</p> ' +
		'</div> ' +
		'<div class="client-shot-address__apartment"> ' +
		'<div class="title">Кв / Офис</div> ' +
		'<p>${APARTMENT}</p> </div> </div>' );

	$.template('orderTemplate','<div class="orders-history-line"> ' +
		'<div class="orders-history-line__show-card" onclick="viewOrder(${ID});">Просмотр</div> ' +
		'<div class="orders-history-line__about-out"> ' +
		'<div class="orders-history-line__about row"> ' +
		'<div class="orders-history-line__date"> ' +
		'<div class="title">Дата</div> ' +
		'<p>${ORDER_DATE}</p> ' +
		'</div> ' +
		'<div class="orders-history-line__order"> ' +
		'<div class="title">Заказ</div> ' +
		'<p>${ORDER_CONTENT}</p> ' +
		'</div> ' +
		'<div class="orders-history-line__total"> ' +
		'<div class="title">Итого</div> ' +
		'<p>${ORDER_SUM} <span class="currency">'+window.currency_f+'</span></p> ' +
		'</div> ' +
		'<div class="orders-history-line__status"> ' +
		'<div class="title">Статус</div> ' +
		'<p>${ORDER_STATUS_NAME}</p> </div> </div> </div> </div>');

	$.ajax({
		url: '/crm/clients/',
		method: 'POST',
		dataType: 'json',
		data: {action: 'getInfo',id: id},
		success: function(data){
			window.view_user = id;
			$(".address-list").html('');
			if(data.CHART.columns[0].length > 0){

				var chart = c3.generate({
					grid: {
						y: {
							show: true
						},
						x: {
							show: true
						}
					},
					legend: {
						show: false
					},
					tooltip: {
						contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
							return '<div class="tooltip-text">'+d[0].value+' <span class="currency">'+window.currency_f+'</span></div>';
						}
					},
					bindto: '#chart',
					data: data.CHART,
					axis: {
						x: {
							type: 'timeseries',
							tick: {
								outer: false,
								values: data.UNIQ_DATES,
								format: '%d.%m'
							},
						}
					}
				});
			}
			$('.favorite-foods-list').html('');
			if(data.TOP_PRODUCTS.length > 0){
				$.each(data.TOP_PRODUCTS,function(i,item){
					if(i == 5) return false;
					$('.favorite-foods-list').append('<div class="favorite-foods__line row"><div class="favorite-foods__name">' +
						'<div class="title">Название</div> ' +
						'<p>'+item.name+'</p> ' +
						'</div> ' +
						'<div class="favorite-foods__quantity"> ' +
						'<div class="title">Количество</div> ' +
						'<p>'+item.amount+'</p> ' +
						'</div> ' +
						'</div>')
				});
			}else{
				$('.favorite-foods-list').html('У пользователя нет любимых блюд');
			}

			if(data.ADDRESSES.length > 0){
				$('.client-preview .address-list').html('');
				$.tmpl( "addressTemplate", data.ADDRESSES ).appendTo( ".address-list" );
			}else{
				$(".address-list").text('Пользователь не добавил адресов')
			}
			if(data.ORDERS.length > 0){
				$('.client-preview .orders-list').html('');
				$('.orders-statistics').show();
				$.tmpl( "orderTemplate", data.ORDERS ).appendTo( ".client-preview .orders-list" );
			}else{
				$('.orders-statistics').hide();
				$('.client-preview .orders-list').text('Пользователь не делал заказов')
			}
			if(data.VIP==1){
				$('.data-client-info__vip-icon').addClass('active');
			}else{
				$('.data-client-info__vip-icon').removeClass('active');
			}
			$('.data-box--registration-source .title').text(data.SOURCE);
			$('.data-box--latest-order .title').text(data.LAST_ORDER || 'Не заказывал');
			$('.data-box--orders .title').text(data.ORDERS_COUNT);
			$('.data-box--total-spent .title span').first().text(data.USER_SUM);
			$('.data-box--spent-bonus .title span').first().text(data.USED_BONUSES);
			$('.data-client-info__scale .counts .summa span').first().text(data.BONUS_VALUE);
			$('.sale-scale li').removeClass('active');
			for (var i = 0; i <= parseInt(data.BONUS_LEVEL); i++) {
				$('.sale-scale li:nth-child('+(3-i)+')').addClass('active');
			}

			if(data.NEED_SUM==undefined){
				$('.is-max').show();
				$('.not-max').hide();
			}else{
				$('.is-max').hide();
				$('.not-max').show();
				$('.not-max span').first().text(data.NEED_SUM);
			}
			if(data.NAME != undefined && data.NAME.length > 0)
				$('.client-preview input[name="NAME"]').val(data.NAME).parent().addClass('filled')
			if(data.PHONE != undefined && data.PHONE.length > 0)
				$('.client-preview input[name="PHONE"]').val(data.PHONE).parent().addClass('filled')
			if(data.EMAIL != undefined && data.EMAIL.length > 0)
				$('.client-preview input[name="EMAIL"]').val(data.EMAIL).parent().addClass('filled')
			if(data.BIRTHDAY != undefined && data.BIRTHDAY.length > 0)
				$('.client-preview input[name="BIRTHDAY"]').val(data.BIRTHDAY).parent().addClass('filled')
			$('[name="NOTIFY_EMAIL"]').val(data.NOTIFY_EMAIL);
			$('[name="NOTIFY_SMS"]').val(data.NOTIFY_SMS);
			if(data.NOTIFY_EMAIL==1){
				$('[name="email_notify"]').attr('checked','checked').parent().addClass('checked');
			}else{
				$('[name="email_notify"]').removeAttr('checked').parent().removeClass('checked');
			}
			if(data.NOTIFY_SMS==1){
				$('[name="sms_notify"]').attr('checked','checked').parent().addClass('checked');
			}else{
				$('[name="sms_notify"]').removeAttr('checked').parent().removeClass('checked');
			}
			masking();

			$('.client-preview .spinner').hide();
			$('.client-preview .wrap').css('opacity',1);

		}
	})

	return false;
}
function number_format( number, decimals, dec_point, thousands_sep ) {

	var i, j, kw, kd, km;
	if( isNaN(decimals = Math.abs(decimals)) ){
		decimals = 2;
	}
	if( dec_point == undefined ){
		dec_point = ",";
	}
	if( thousands_sep == undefined ){
		thousands_sep = ".";
	}

	i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

	kw = i.split( /(?=(?:\d{3})+$)/ ).join( thousands_sep );
	kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


	return kw + kd;
}
var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(parseInt(date)) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();
function plural(number, one, two, five) {
	number = Math.abs(number);
	number %= 100;
	if (number >= 5 && number <= 20) {
		return five;
	}
	number %= 10;
	if (number == 1) {
		return one;
	}
	if (number >= 2 && number <= 4) {
		return two;
	}
	return five;
}
// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};
function onlyUnique(value, index, self) {
	return self.indexOf(value) === index;
}