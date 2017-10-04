function renderBasket(){
    $(".products-list.scroll-content").html('');
    $('.basket-items-col .spinner').show();
    $.ajax({
        dataType: "json",
        url: '/include/ajax1/basket.php?action=getBasket',
        success: renderBasketItems
    });
}
function renderBasketItems(data){
    if(data.cashback){
        animateNumbers($('.basket-actions .bonuses-info span').first(),data.cashback);
        animateNumbers($('.checkout-footer .bonuses-info span').first(),data.cashback);
    }
    if(data.promo || data.discount){
        if(data.discount !== undefined && data.discount!==null && data.discount!==0){
            $('.basket-actions .order-discount span').first().parent().show();
            animateNumbers($('.basket-actions .order-discount span').first(),data.discount);
            animateNumbers($('.checkout-footer .order-discount span').first(),data.discount);
            $('.checkout-footer .order-discount span').first().parent().show();
            $('.basket-actions .order-total').find('.summary-label').hide();
            $('.checkout-footer .order-total').find('.summary-label').hide();

            $('.ot-cont').addClass('with-promo');
            $('.checkout-footer').addClass('with-promo');
        }else{
            $('.basket-actions .order-discount span').first().parent().hide();
            $('.checkout-footer .order-total').find('.summary-label').show();
            $('.basket-actions .order-total').find('.summary-label').show();

            $('.ot-cont').removeClass('with-promo');
            $('.checkout-footer').removeClass('with-promo');
            $('.checkout-footer .order-discount').hide();
            $('.basket-actions .order-discount').hide();
        }
        if(data.promo){
            $('.basket-promo-code').val(data.promo).parent().addClass('filled ok');
            $('.basket-promo-code').parent().find('.apply-code-btn').addClass('ok');
        }else{
            $('.basket-promo-code').val('').parent().removeClass('filled ok');
            $('.basket-promo-code').parent().find('.apply-code-btn').removeClass('ok');
        }
    }else{
        $('.checkout-footer .order-discount').hide();
        $('.basket-actions .order-discount').hide();

    }
    $(".basket .basket-view .products-list").html('');
    $.tmpl( "basketTemplate", data.products ).appendTo(".basket .basket-view .products-list");
    $('.basket-items-col .spinner').hide();
    setTimeout(function(){
        $('.basket-item .change-amount-btn').off().on('click',function(e){
            e.preventDefault();
            var $basket_item = $(this).closest('.basket-item');
            var current_val = $basket_item.find('.buttons').find('input[type="hidden"]').val();
            var new_val = parseInt(current_val);
            var product_id = $basket_item.data('id');
            var price = parseInt($basket_item.data('price'));
            if($(this).hasClass('plus')){
                new_val++;
            }else{
                new_val--;
            }
            if(new_val==0)
                new_val = 1;
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': product_id, 'AMOUNT': new_val},
                dataType: "json",
                url: '/include/ajax1/basket.php?action=changeAmount',
                success: function(data){
                    var has_gift = false;
                    $.each(data.products,function(i,item){
                        if(item.INDEX=='gift'){
                            has_gift = true;
                        }
                        $basket_item = $('.basket-item[data-id="'+item.INDEX+'"]');
                        $basket_item.find('.buttons .amount').text(item.AMOUNT);
                        $basket_item.find('.buttons input[type="hidden"]').val(item.AMOUNT);
                        animateNumbers($basket_item.find('.product-sum span').first(),item.LOCAL_SUM.replace(' ',''));
                    });
                    var $gift_item = $('.basket-item[data-id="gift"]');
                    if($gift_item.length>0 && !has_gift){
                        $gift_item.remove();
                        if($('.get-another-gift-btn').length){
                            $('.get-another-gift-btn').trigger('click')
                        }
                    }

                    renderSummary(data);
                }
            });
            return false;
        });
        $('.remove-basket-item').off().on('click',function(e){

            if($('.constructor-view').is(':visible')){
                $('.constructor-view .close-view').trigger('click');
            }
            e.preventDefault();
            var $basket_item = $(this).closest('.basket-item');
            var product_id = $basket_item.attr('data-id');
            if(product_id=='gift' && $('.get-another-gift-btn').length){
                $('.get-another-gift-btn').trigger('click')
            }else{

                $('.product[data-id="'+$basket_item.attr('data-pid')+'"]').find('.add-to-cart-btn').removeClass('retry').text(BX.message('add_basket'));
                $.ajax({
                    type: 'post',
                    data: {'PRODUCT_ID': product_id},
                    dataType: "json",
                    url: '/include/ajax1/basket.php?action=remove',
                    success: function(data){
                        var has_gift = false;
                        $.each(data.products,function(i,item) {
                            if (item.INDEX == 'gift') {
                                has_gift = true;
                            }
                            if(item.ID.indexOf('additional_')!==-1){
                                $('.basket_item_is_additional[data-id="'+item.ID+'"] .buttons').find('.amount').text(item.AMOUNT);
                                $('.basket_item_is_additional[data-id="'+item.ID+'"] .buttons').find('input[type="hidden"]').val(item.AMOUNT);
                            }
                        });


                        $basket_item.remove();
                        var $gift_item = $('.basket-item[data-id="gift"]');
                        if($gift_item.length>0 && !has_gift){
                            $gift_item.remove();
                            if($('.get-another-gift-btn').length){
                                $('.get-another-gift-btn').trigger('click')
                            }
                        }
                        renderSummary(data);
                    }
                });
            }

            return false;
        });
        $('.basket-item .name,.basket-item .product-image').off().on('click',function(){

            if(!$(this).closest('.basket-item').hasClass('without_detail')){
                $(window).scrollTop(0);
                var id = $(this).closest('.basket-item').data('id');

                $.ajax({
                    type: 'post',
                    data: {PRODUCT_ID: id},
                    dataType: "json",
                    url: '/include/ajax1/basket.php?action=getBasketItemDetail',
                    success: function(data){
                        $('.basket-view .status-bar .title').html(data.NAME);
                        $('.information-col .close-view').show();
                        $('.information-col .apply-view').hide();
                        $('.product-info-cont .constructor-view .product-image img').attr('src',data.PREVIEW_PICTURE_M.src);
                        $('.product-info-cont .constructor-view .name').attr('data-id',id).html();
                        if(data.TYPE=='native'){
                            $('.product-info-cont .like-content span').text(data.LIKE_COUNTER);
                            $('.basket-view.change-view .product-description').text(data.PREVIEW_TEXT);
                            $('.product-info-cont .likes').attr('data-id',data.ID).show();
                            if(data.isLiked==1){
                                $('.product-info-cont .likes').addClass('liked');
                            }else{
                                $('.product-info-cont .likes').removeClass('liked');
                            }
                            $('.basket .change-view .product-options').html('');
                            if(data.OPTIONS!=null){
                                var ji = 0;
                                $.each(data.BD_PROPS,function(key,item){
                                    var content = '<div class="options-row-select col-xl-'+parseInt(12/parseInt(data.BD_PROPS.length))+' col-lg-12"><select data-placeholder-option="true">';
                                    content += '<option value="null">'+data.OPTIONS_NAME[ji+1]+'</option>';
                                    $.each(item,function(skey,sitem){
                                        var selected = '';
                                        if(ji==0 && skey==parseInt(data.OPTIONS.OPTION_1)){
                                            selected = 'selected="selected"';
                                        }
                                        if(ji==1 && skey==parseInt(data.OPTIONS.OPTION_2)){
                                            selected = 'selected="selected"';
                                        }
                                        content+= '<option '+selected+' value="'+skey+'" data-price="'+sitem.PRICE+'" data-old-price="'+sitem.OLD_PRICE+'" data-weight="'+sitem.WEIGHT+'">'+sitem.VALUE+'</option>';
                                    });
                                    content +="</select></div>";
                                    $('.basket .change-view .product-options').append(content);
                                    ji++;
                                });
                                $('.change-view .product-actions').show();
                            }else{
                                $('.change-view .product-actions').hide();
                            }
                            $('.basket .basket-view.change-view .apply-view').attr('disabled','disabled');
                            $('.basket .change-view .product-options select').on('change',function(){
                                $('.basket .basket-view.change-view .apply-view').removeAttr('disabled');
                            }).selectOrDie();
                            $('.basket .change-view .product-prices .weight').text(data.G);
                            registerLikes();
                            $('.product-info-cont .constructor-view .constructor-scroll-content').hide();
                            $('.product-info-cont .constructor-view .product-scroll-content').show();
                        }else{
                            $('.basket-view .back').attr('onclick','backToBasket()')
                            $('.product-detail-cont').show();
                            $('.product-info-cont .likes').hide();
                            $('.product-info-cont .constructor-content .ingredients_list_').html('');
                            $('.product-info-cont .constructor-content .base_value_').text(data.BASE);
                            $('.product-info-cont .constructor-content .souse_value_').text(data.SOUSE);
                            $.each(data.INGREDIENTS,function(i,item){
                                $('.product-info-cont .constructor-content .ingredients_list_').append('<div class="property-value">'+item+'</div>')
                            })

                            $('.product-info-cont .constructor-view .constructor-scroll-content').last().show();
                            $('.change-view .product-actions').hide();
                        }
                        $('.product-info-cont').show();
                        $('.basket-view.main-view').hide();
                    }
                });
            }
        });
    },1000)
    renderSummary(data);
}
function registerLikes(){
    if($('.likes').length){
        $('.likes').off('click').on('click',function(e){
            e.preventDefault();
            var $cont = $(this).closest('.preview');
            if($cont.length == 0){
                $cont = $(this);
            }

            if(window.user_id!=0){
                if($(this).hasClass('liked')){
                    $(this).removeClass('liked');
                }else{
                    $(this).addClass('liked');
                }
            }
            var product_id = $(this).closest('.product').data('id');
            if(product_id == undefined){
                product_id = $(this).attr('data-id');
            }

            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': product_id},
                dataType: "json",
                url: '?action=likeItem',
                success: function(data){
                    $cont.find('.like-content span').text(data);
                }
            });
            return false;
        })
    }
}
function renderSummary(data){
    if(data.products.length == 0){
        $('.close-basket').hide();
        $('.basket-toggle svg').show();
        $('.basket-header-sum span').first().text(0).parent().hide();
        $('.basket-toggle').removeClass('active_')
        $('.basket.basket-p').hide();
        $('#page').show();
        $('.header .title span').text(window.default_title).show();
        $('.header .title img').show();
    }
    var min_order = parseInt($('.min-order-progress').data('min-order'));
    if(data.basket_sum>=min_order){
        if($('.send-order').length){
            $('.send-order').removeAttr('disabled');
        }
        $('.min-order-progress').hide();
        $('.min-order-progress').find('.progress-bar').css('width','100%');
        $('#checkout-form .checkout-btn').css('display','block');;
    }else{
        $('#checkout-form .send-order').attr('disabled','disabled');
        $('.min-order-progress').show();
        $('.min-order-progress').find('.progress-bar').css('width',parseInt(data.basket_sum/min_order*100)+'%');
        $('#checkout-form .checkout-btn').css('display','none');
    }

    if(data.products.length>0){
        if(data.basket_sum == 0){
            // && data.discount!==null && data.discount!==undefined
            if(!isNaN(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum - window.prev_delta))
                $('[name="ORDER[DISCOUNT_BONUSES]"]').val(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum - window.prev_delta);

            window.prev_delta = 0;
            if(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val())+data.basket_sum > min_order){
                $('.send-order').removeAttr('disabled');
            }
        }
        if(data.basket_sum < 0){
            $('[name="ORDER[DISCOUNT_BONUSES]"]').val(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum );
            window.prev_delta = data.basket_sum;
            data.basket_sum = 0;
            $('.send-order').removeAttr('disabled');
        }
        if(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum > 0){
            $('.send-order').removeAttr('disabled');
        }

        animateNumbers($('.basket-header-sum span').first(),data.basket_sum);

        if(!$('.basket').is(':visible') || $('.h-order-view').is(':visible')){
            $('.basket-header-sum').show();
            if(data.products.length>0){
                $('.basket-toggle').addClass('active_').find('svg').hide();
            }else{
                $('.basket-toggle').removeClass('active_').find('svg').show();
            }
        }
        animateNumbers($('.basket-actions .bonuses-info span').first(),data.cashback);
        animateNumbers($('.checkout-footer .bonuses-info span').first(),data.cashback);
        if(data.promo!==undefined && $('.bonuses-with-promo-disabled').length){
            $('.bonuses-with-promo-disabled').show();
            $('.checkout-footer .bonuses-info .default-text').hide();
            $('.basket-actions .bonuses-info .default-text').hide();
        }else{
            $('.bonuses-with-promo-disabled').hide();
            $('.checkout-footer .bonuses-info .default-text').show();
            $('.basket-actions .bonuses-info .default-text').show();
        }
        animateNumbers($('.not-empty-basket').find('.basket-sum span').first(),data.basket_sum);
        animateNumbers($('.basket-actions .order-sum span').first(),data.basket_sum);
        animateNumbers($('.checkout-footer .order-sum span').first(),data.basket_sum);
        if(data.basket_sum_gift >= window.limit1){
            var basket_has_gift = false;
            for(prod in data.products){
                if(data.products[prod].INDEX=='gift'){
                    basket_has_gift = true;
                }
            }

            $('.gift-progress').hide();

            if(basket_has_gift==true){
                $('.gift-progress-complete a').html(BX.message('get_another_gift')).parent().show().addClass('reuse');
            }else{
                $('.gift-progress-complete a').html(BX.message('get_gift')).parent().show().removeClass('reuse').addClass('use');
            }
        }else{
            var percent = parseInt(data.basket_sum_gift/window.limit1*100);

            $('.gift-progress').show().find('.progress-bar').css('width',percent+'%');
            animateNumbers($('.gift-progress .sum-to-gift span').first(),window.limit1-data.basket_sum_gift);
            $('.gift-progress-complete').hide();
            $('.gift-progress').show();
        }
    }else{
        $('body').trigger('click');
        $('.basket-sum span').first().text(0);
        $('.empty-basket').show();
        $('.not-empty-basket').hide()
    }

    calcGifts(data.basket_sum_gift);
}
function getConstructorView(viewName){
    $('.constructor-view').hide();
    $('.constructor-view.'+viewName+'-view').show();
    if(viewName == 'ingredient-list'){
        $('.back').attr('onclick','getConstructorView("add-ingredient")').attr('href','#');
    }
    if(viewName == 'main'){
        $('.back').attr('onclick','window.location.href="/catalog/"');
        $('.status-bar .title').text(BX.message('wok_box_title'))
    }
    if(viewName == 'base'){
        $('.status-bar .title').text(BX.message('wok_base'))
        $('.back').attr('onclick','getConstructorView("main")').attr('href','#');
    }
    if(viewName == 'souse'){
        $('.status-bar .title').text(BX.message('wok_souce'))
        $('.back').attr('onclick','getConstructorView("main")').attr('href','#');
    }
    if(viewName == 'presets'){
        $('.status-bar .title').text(BX.message('wok_ready_box'))
        $('.back').attr('onclick','getConstructorView("main")').attr('href','#');
    }
    if(viewName == 'add-ingredient'){
        $('.status-bar .title').text(BX.message('wok_ingredients'))
        $('.back').attr('onclick','getConstructorView("main")').attr('href','#');
    }
}
function getCheckoutView(viewName){
    $('.checkout-view').hide();
    $('.checkout-view.'+viewName+'-view').show();
    if(viewName == 'main'){
        $('.status-bar').hide();
        $(window).scrollTop( window.order_scroll);
    }else{
        $('.status-bar').show();
        if(viewName=='my-adresses'){
            $('.status-bar .title').text(BX.message('choise_address'));
        }
        if(viewName=='payment-type'){
            $('.status-bar .title').text(BX.message('type_delivery'));
        }
        if(viewName=='set-pickup'){
            $('.status-bar .title').text(BX.message('takeaway'));
        }
        if(viewName=='new-address'){
            $('.status-bar .title').text(BX.message('address_delivery'));
        }
        if(viewName=='delivery-regions'){
            $('.status-bar .title').text(BX.message('destrict'));
        }
        if(viewName=='order-date'){
            $('.status-bar .title').text(BX.message('choise_date'));
        }
    }
    if(viewName == 'my-adresses' || viewName == 'payment-type' || viewName == 'new-address' || viewName == 'order-date' || viewName == 'set-pickup'){
        $('.back').attr('onclick','getCheckoutView("main")').attr('href','#');
    }
    if(viewName == 'delivery-regions'){
        $('.back').attr('onclick','getCheckoutView("new-address")').attr('href','#');
    }

}
function getProfileView(viewName){
    $('.profile-view').hide();
    $('.profile-view.'+viewName+'-view').show();
    if(viewName == 'districts'){
        $('.back').attr('onclick',"getProfileView('address')");
    }else{
        $('.back').attr('onclick',"getProfileView('personal')").attr('data-target-title',BX.message('ls'))
    }
    if(viewName == 'address'){
      $('.status-bar .title').text($('.address-view').find('input[name="ADDRESS[NAME]"]').val() || BX.message('ls'));
    }
    if(viewName == 'personal'){
      $('.status-bar .title').text(BX.message('ls'));
        $('.back').attr('onclick',"openMainProfileNav()")
    }
    if($('.history-view').length){
        if(viewName.indexOf('order')!==-1){
            $('.back').attr('onclick',"getProfileView('history')").attr('data-target-title',BX.message('history'));
            $('.status-bar .title').text($('.'+viewName+'-view').data('target-title'));
        }else{
            $('.back').attr('onclick',"openMainProfileNav()");
            //$('.status-bar .title').text(BX.message('ls'));
        }
        if(viewName  == 'history'){
            $('.status-bar .title').text(BX.message('history'))
        }
    }

}
function animateNumbers(elem,new_val){
    $({val_i: parseInt($(elem).text().split(' ').join(''))}).animate({val_i: parseInt(new_val)}, {
        duration: 500,
        easing: 'swing',
        step: function () {
            $(elem).text(number_format(this.val_i, 0, '.', ' '));
        },
        complete: function () {
            $(elem).text(number_format(new_val, 0, '.', ' '));
        }
    })
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
function validateProperties(product){
    var valid = [];
    if(product.find('select').length){
        product.find('select').each(function (i, item) {
            if($(item).val()==null || ($(item).val().toString()=='null')){
                valid.push(false);
                $(item).closest('.sod_select').addClass('error_ shake');
                setTimeout(function(){
                    $(item).closest('.sod_select').removeClass('shake');
                },1500);
            }else{
                valid.push(true)
                $(item).closest('.sod_select').removeClass('error_ shake');
            }
        });
    }else{
        valid.push(true)
    }

    if(valid.indexOf(false)!==-1){
        return false;
    }else{
        return true;
    }
}
function registerProductListeners(){
    if(window.user_id == 0 && $('.likes').length > 0){
        $('.likes').addClass('guest-likes');
    }
    $('.basket .change-view .apply-view').off().on('click',function (e) {
        e.preventDefault();
        var options = {};
        if($('.basket .change-view  .product-options select').length==1){
            options.OPTION_1 = $('.basket .change-view  .product-options select').first().val();
        }
        if($('.basket .change-view  .product-options select').length==2){
            options.OPTION_1 = $('.basket .change-view  .product-options select').first().val();
            options.OPTION_2 = $('.basket .change-view  .product-options select').last().val();
        }
        $.ajax({
            type: 'post',
            data: {'PRODUCT_ID': $('.basket .change-view  .name').attr('data-id'), 'OPTIONS': options},
            dataType: "json",
            url: '/bitrix/components/bd/basket_pizza/component.php?action=updateOptions',
            success: function(data){
                $('.basket .basket-view.change-view').hide();
                renderBasket();
            }
        });
        return false;
    })
    $('.product select').off().on('change',function(){
        var $product = $(this).closest('.product');
        var $prices = $(this).closest('.product').find('.product-prices');
        var mode = 1;
        if($(this).closest('.options-row-select').hasClass('options-length-2')){
            mode = 2;
        }
        var new_price, new_old_price, new_weight;


        new_price = parseInt($product.find('select').first().find('option:selected').data('price'));
        new_old_price = parseInt($product.find('select').first().find('option:selected').data('old-price'));
        new_weight = parseInt($product.find('select').first().find('option:selected').data('weight'));

        if(mode==2){
            new_price += parseInt($product.find('select').last().find('option:selected').data('price'));
            if(!isNaN(parseInt($product.find('select').last().find('option:selected').data('old-price'))))
                new_old_price += parseInt($product.find('select').last().find('option:selected').data('old-price'));
            new_weight += parseInt($product.find('select').last().find('option:selected').data('weight'));
        }

        if(!isNaN(new_price)){
            $prices.find('.current-price span').first().text(number_format(new_price,0, '.', ' '));
        }
        if(!isNaN(new_old_price)){
            $product.find('.product-footer').removeClass('base-price');
            $prices.find('.old-price .line-through').text(number_format(new_old_price,0, '.', ' ')).parent().show();
        }else{
            $product.find('.product-footer').addClass('base-price');
            $prices.find('.old-price').hide();
        }

        if(!isNaN(new_weight)){
            $prices.find('.weight').find('span').first().text(new_weight);
        }
        $(this).selectOrDie('update');

    });
    $('.product-actions .add-to-cart-btn').off().on('click',function(e){
        if($('.lic').length) return;
        if($(this).closest('.product-actions').hasClass('progress-complete')) return false;
        if(window.yaCounter!=undefined && window.yaCounter != null){
            yaCounter.reachGoal('add-to-basket',{});
        }
        if(ga!=undefined){
            ga('send', 'event', 'basket', 'add');
        }
        e.preventDefault();
        var $self = $(this);
        var options = {};
        if($self.closest('.product').find('select').length == 1){
            options.OPTION_1 = $self.closest('.product').find('select').first().val();
        }
        if($self.closest('.product').find('select').length == 2){
            options.OPTION_1 = $self.closest('.product').find('select').first().val();
            options.OPTION_2 = $self.closest('.product').find('select').last().val();
        }
        var $prod = $self.closest('.product');

        if(validateProperties($prod)){
            var cart = $('.basket-btn-container');
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': $self.data('id'),options:options},
                dataType: "json",
                url: '/include/ajax1/basket.php?action=addToBasket',
                success: function(data){
                    renderBasket();
                }
            });
            $('.product[data-id="'+$self.data('id')+'"]').find('.add-to-cart-btn').addClass('retry').text(BX.message('get_more'));
            if(!$self.hasClass('retry'))
                $self.addClass('retry').text(BX.message('get_more'));
        }
        return false;
    });
}
function setAuthState(state){
    $('.header .title span').text(BX.message('auth_text')).show();
    $('.auth-state').hide();
    $('.auth-state.'+state).show();
    if(state == 'forgot-password-state' || state == 'phone-confirm-password-state' || state == 'set-new-password-state' || state == 'phone-confirm-password-state' || state == 'set-new-password-state' || state == 'agreement-state'){
        $('.auth-tabs').hide();
        $('.auth-status-bar .back').show();
        $('.auth-status-bar').css('height','48px');
    }else{
        $('.auth-status-bar .back').hide();
        $('.auth-tabs').show();
        $('.auth-status-bar').css('height','70px');
    }
    $('.status-bar .title').text('');
    var type = window.auth_type;

    if(state == 'forgot-password-state'){
        if(type=='sms')
            type = 'default'
        $('.status-bar .title').text(BX.message('forgot_password'));
        $('.status-bar .back').attr('onclick','setAuthState("sign-in-'+type+'-state")');
    }

    if(state == 'agreement-state'){
        if(type=='sms')
            type = 'phone'
        $('.status-bar .title').text(BX.message('agree_license'));
        $('.status-bar .back').attr('onclick','setAuthState("sign-up-'+type+'-state")');
    }
}
function checkPromoAjax(){
    var $input = $('.basket-promo-code');
    var code_ = $input.val();
    $.ajax({
        type: 'post',
        data: {CODE: code_},
        dataType: "json",
        url: '/include/ajax1/basket.php?action=checkPromo',
        success: function(data){
            if(data.status==1){
                $input.closest('.bd-input').removeClass('error').addClass('ok');
                $input.parent().find('.apply-code-btn').addClass('ok');
                $('.ot-cont').addClass('with-promo');
            }
            if(data.status==0){
                $input.closest('.bd-input').removeClass('ok').addClass('error');
                $input.parent().find('.apply-code-btn').removeClass('ok');
                $('.ot-cont').removeClass('with-promo');
            }
            renderBasket();
            if($('select[name="ORDER[DISTRICT_ID]"]').length){
                $('select[name="ORDER[DISTRICT_ID]"]').trigger('change');
            }
        }
    });
}
function removeFromConstructor(id){
    if($('.constructor-ingredient-basket-item[data-id="'+id+'"]').attr('data-auto') == 'true'){
        $('#constructor_form').append('<input type="hidden" name="EXCLUDE_AUTO[]" value="'+id+'" />');
    }
    $('input[name="INGREDIENTS[]"][value="'+id+'"]').remove();
    $('.constructor-ingredient-basket-item[data-id="'+id+'"]').remove();
    $('.ingredient-list-view .bd-row-checkbox[data-id="'+id+'"]').removeClass('active');
    calculateConstructor();
}
function validateConstructor(){
    if(
        $('[name="BASE_ID"]').val().trim().length > 0 &&
        $('[name="SOUSE_ID"]').val().trim().length > 0
    ){
        $('.add-to-cart-constructor').removeAttr('disabled');
        return true;
    }else{
        $('.add-to-cart-constructor').attr('disabled','disabled');
        return false;
    }
}
function calculateConstructor(){
    $.ajax({
        type: 'post',
        data: $('#constructor_form').serialize(),
        dataType: "json",
        url: '/bitrix/components/bd/constructor_pizza/component.php?action=calculateConstructor',
        success: function(data){
            validateConstructor();
            if(data.INGREDIENTS!=null){
                $(".ingredients-list").html('');
                $.tmpl( "constructorIngredientBasketTemplate", data.INGREDIENTS).appendTo(".ingredients-list");
                $.each(data.INGREDIENTS,function(i,item){
                    if($('input[name="INGREDIENTS[]"][value="'+item.ID+'"]').length==0){
                        $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="'+item.ID+'">');
                        $('.ingredient-list-view .bd-row-checkbox[data-id="'+item.ID+'"]').addClass('active');
                    }
                })
                registerIngredientChangeAmountListener();
            }
            if(parseInt(data.SUM)){
                $('.clear-constructor').show();
            }
            $('.constructor-summary .sum-value span').first().text(data.SUM);
            $('.constructor-summary .weight span').first().text(data.WEIGHT);
            $('#constructor_form input[name="PRICE"]').val(data.SUM);
            $('#constructor_form input[name="WEIGHT"]').val(data.WEIGHT);
        }
    });
}
function registerIngredientChangeAmountListener(){
    $('.constructor-ingredient-basket-item .change-amount-btn').off().on('click',function(e){
        e.preventDefault();
        var $basket_item = $(this).closest('.constructor-ingredient-basket-item');
        var current_val = $basket_item.find('.buttons').find('input[type="hidden"]').val();
        var new_val = parseInt(current_val);
        if($(this).hasClass('plus')){
            new_val++;
        }else{
            new_val--;
        }
        if(new_val==0)
            new_val = 1;

        $basket_item.find('.buttons').find('input[type="hidden"]').val(new_val)
        calculateConstructor();
        return false;
    });
    $('.constructor-ingredient-basket-item .remove-basket-item a').off().on('click',function(e){
        removeFromConstructor($(this).parent().data('id'));
        return false;
    });
}
Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}
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
function getProfileMainPage(){
    $('.profile-view.address-view').find('input[name="ADDRESS[ID]"]').val('');
    $('.profile-view.address-view').find('input[name="ADDRESS[NAME]"]').val('');
    $('.profile-view.address-view').find('input[name="ADDRESS[STREET]"]').val('');
    $('.profile-view.address-view').find('input[name="ADDRESS[HOUSE]"]').val('');
    $('.profile-view.address-view').find('input[name="ADDRESS[APARTMENT]"]').val('');
    $('.profile-view.personal-view').show();
    $('.profile-view.address-view').hide();
}
function getAddressForm(){
    $('.status-bar .back').attr('onclick','getProfileView("personal")')
    var $cont = $('.profile-view.address-view');
    $cont.find('input[name="ADDRESS[ID]"]').val('');
    $cont.find('input[name="ADDRESS[NAME]"]').val('');
    $cont.find('input[name="ADDRESS[STREET]"]').val('');
    $cont.find('input[name="ADDRESS[HOUSE]"]').val('');
    $cont.find('input[name="ADDRESS[APARTMENT]"]').val('');
    $cont.find('[name="ADDRESS[DISTRICT_ID]"]').val('');
    $('.address-view .address-item').text(BX.message('change_destrict'))
    $('.profile-view.personal-view').hide();
    $('.profile-view.address-view').show();
    $('.districts-view .bd-row-checkbox').removeClass('active');
}
function calcGifts(sum){
    if($('.gift-item').length){
        $('.gift-item').each(function(i,item){
            var limit = parseInt($(item).find('.gift-progress-info').data('limit'));
            var percent = sum/limit*100;
            $(item).find('.gift-progress-value').text(limit-sum);
            if(limit>sum){
                $(item).find('.progress-container .progress-bar').css('width',percent+'%');
                $(item).find('.gift-progress-info').show();
                $(item).find('.get-gift').hide();
            }else{
                $(item).find('.gift-progress-info').hide();
                $(item).find('.get-gift').show();
            }
        });
        if(sum < window.limit1){
	        $('.gift-item').removeClass('active masked').find('.get-gift').removeClass('get-another-gift').text('Выбрать');
        }
    }

}
function backToBasket(){
   $('.basket-view').hide();
   $('.basket-view.main-view').show();
}
function openMainProfileNav(){
    var api = $("#menu").data("mmenu");
    api.close();
    $('#page').hide();
    $('.profile-view.main-view').show().css('margin-top','50px');
    $('.header a').removeClass('opened').html('');
    $('.header .title span').text(BX.message('ls')).show();
}
function processAddress(){
    $('.delivery-type-tab-1 .config-item a').text($('[name="ORDER[STREET]"]').val()+BX.message('homee')+$('[name="ORDER[HOUSE]"]').val()+BX.message('appartaments')+$('[name="ORDER[APARTMENT]"]').val());
    $('.back:visible').trigger('click');
}
function validateOrder(){
	if($('[name="ORDER[USER_NAME]"]').length > 0){
	    var error = 0;
	    if($('[name="ORDER[USER_NAME]"]').val().trim().length == 0){
	        error = 1;
	    }
	    if($('[name="ORDER[USER_PHONE]"]').val().trim().length == 0){
	        error = 1;
	    }
	    if($('[name="ORDER[PAYMENT_TYPE]"]').val().trim().length == 0){
	        error = 1;
	    }
	    if($('[name="ORDER[DELIVERY_PICKUP_ID]"]').val().trim().length == 0){
	        if($('[name="ORDER[DISTRICT_ID]"]').val().trim().length == 0){
	            error = 1;
	        }
	        if($('[name="ORDER[STREET]"]').val().trim().length == 0){
	            error = 1;
	        }
	        if($('[name="ORDER[HOUSE]"]').val().trim().length == 0){
	            error = 1;
	        }
	        if($('[name="ORDER[APARTMENT]"]').val().trim().length == 0){
	            error = 1;
	        }
	    }
    }
}
function validateAddress(){
    var error = 0;
    if($('[name="ORDER[STREET]"]').val().trim().length == 0)
        error = 1;

    if($('[name="ORDER[HOUSE]"]').val().trim().length == 0)
        error = 1;

    if($('[name="ORDER[APARTMENT]"]').val().trim().length == 0)
        error = 1;

    if($('[name="ORDER[DISTRICT_ID]"]').val().trim().length == 0)
        error = 1;

    if(error == 0){
        $('.new-address-view button').removeAttr('disabled');
    }else{
        $('.new-address-view button').attr('disabled','disabled');
    }
}
$(document).ready(function () {
    $('body').on('click','.accordion__item__head', function () {
        $(this).parent().toggleClass('open close');

        return false;
    });

	$('.profile-view .checkout-btn').on('click',function(e){
        e.preventDefault();
        var $self = $(this);
        $.ajax({
            type: 'post',
            data: {'ORDER_ID': $self.data('id')},
            dataType: "json",
            url: '/bitrix/components/bd/checkout_pizza/component.php?action=reorder',
            success: function(data){
	            setTimeout(function(){
		        	renderBasket();
	            }, 1000);

            }
        });
        return false;
    })
    sbjs.init();
    $.cookie('t_source', sbjs.get.current.typ+'|'+sbjs.get.current.src,{path: '/'})
    if($('.main-view').length){
        window.order_scroll = 0;
        $(window).on('scroll',function(e){
            if($('.main-view').is(':visible'))
                window.order_scroll = $(window).scrollTop();
        });
    }
    if($('.carousel').length){
        var $carousel = $('.carousel').flickity({
            cellAlign: 'center',
            contain: true,
            autoPlay: 3000,
            percentPosition: false,
            prevNextButtons: false
        });
        $('.bd-slider').css('opacity','1');
        $('.slider-container .spinner').hide();
        var flkty = $carousel.data('flickity');
        $($('.flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');

        $carousel.on('select.flickity', function() {
            $('.flickity-page-dots .dot').removeClass('completed');

            $($('.flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');
        });
    }
    $('#checkout-form input').on('keyup',function(){
        validateOrder();
    })

    $('.sub-categories-toggle').on('click',function(e){
        e.preventDefault();
        var $li = $(this).closest('li');
        if($li.hasClass('opened')){
            $li.removeClass('opened');
            $li.find('ul').slideUp();
        }else{
            $li.addClass('opened');
            $li.find('ul').slideDown();
        }
        return false;
    })
    $('#constructor_form').on('submit',function(e){
        e.preventDefault();
        if(validateConstructor()){

            $.ajax({
                type: 'post',
                data: $('#constructor_form').serialize(),
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=addToBasket',
                success: function(data){
                    renderBasket();
                    $('.clear-constructor').trigger('click');
                }
            });
        }
    });
    $('.clear-constructor').on('click',function(e){
        e.preventDefault();
        $('[data-var-name="base"]').text(BX.message('wok_get_base'));
        $('[data-var-name="souse"]').text(BX.message('wok_get_souce'));
        $('[data-var-name="presets"]').text(BX.message('wok_get_ready_box'));
        $(this).hide();
        $('.preset-item').removeClass('active');
        $('input[name="INGREDIENTS[]"]').remove();
        $('input[name="EXCLUDE_AUTO[]"]').remove();
        $('.constructor-ingredient-basket-item').remove();
        $('.base-item').removeClass('active');
        $('.bd-row-checkbox').removeClass('active');
        $('input[name="BASE_ID"]').val('');
        $('input[name="SOUSE_ID"]').val('');
        $('input[name="WEIGHT"]').val('');
        $('input[name="PRICE"]').val('');
        $('input[name="IMAGE"]').val(window.template_path+'/images/constructor-image.jpg');
        $('input[name="NAME"]').val(BX.message('wok_js_box'));
        $('.constructor-main-image img').attr('src',window.template_path+'/images/constructor-image.jpg');
        calculateConstructor();
        return false;
    });
    $('.ingredient-item').on('click',function(e){
        if(!$(e.target).hasClass('delete')) {
            $(this).addClass('active');
            if($('input[name="INGREDIENTS[]"][value="'+$(this).data('id')+'"]').length == 0){
                $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="'+$(this).data('id')+'"/>');

            }
            if($('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]')){
	            $('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]').remove();
            }
            calculateConstructor();
        }
    });
    $('.ingredient-item .delete').on('click',function(e){
        $(this).closest('.ingredient-item').removeClass('active');
        removeFromConstructor($(this).data('id'));
    });
    registerProductListeners();
    renderBasket();
    registerLikes();
    var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1;
	if(!isAndroid){
    	$('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').mask(window.phone_mask,{placeholder:" "});
    }else{
	    var country_code = window.phone_mask.replace(RegExp(' ','g'), '').replace('(','').replace(')', '').replace(new RegExp('9','g'),'').replace(new RegExp('-','g'),'');
	    var cleared_mask_length = window.phone_mask.replace(RegExp(' ','g'), '').replace('(','').replace(')', '').replace(new RegExp('-','g'),'').length;

	    $('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').each(function(){
		    if($(this).val().length){
			    $(this).val('+'+$(this).val())
		    }else{
				$(this).val(country_code)
			}
	    })
		$('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').attr('maxlength',cleared_mask_length);
	    $('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').on('keyup',function(){
		    if($(this).val().indexOf(country_code)){
			    $(this).val(country_code);
		    }
	    });
    }
    if(isAndroid){
		$('input[name="ORDER[DELIVERY_TIME]"],input[name="ORDER[DELIVERY_TIME_2]"]').off('keyup').on('keyup',function(){
	        var parsed_time = $(this).val().split(':');
			if($(this).val().length==2){
				$(this).val($(this).val()+':')
			}
	        if(parseInt(parsed_time[0])>23)
	            parsed_time[0] = 23;

	        if(parseInt(parsed_time[1])>59)
	            parsed_time[1] = 59;

//	        $(this).val(parsed_time[0]+':'+parsed_time[1]);

	    });
	}else{
		$('input[name="ORDER[DELIVERY_TIME]"],input[name="ORDER[DELIVERY_TIME_2]"]').mask("99:99",{placeholder:" "});
	}
	if(!isAndroid)
	    $('.delivery_time').mask('99:99');

    $('input[name="USER[BIRTHDAY]"]').mask("99.99.9999",{placeholder:" "});


    if($('.carousel').length){
        var $carousel = $('.carousel').flickity({
            cellAlign: 'center',
            contain: true,
            autoPlay: 3000,
            percentPosition: false,
            prevNextButtons: false,
        });
        $('.bd-slider').css('opacity','1');
        $('.slider-container .spinner').hide();
        var flkty = $carousel.data('flickity');
        $($('.flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');

        $carousel.on('select.flickity', function() {
            $('.flickity-page-dots .dot').removeClass('completed');

            $($('.flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');
        });
    }
    $("#menu").mmenu({
        transitionDuration: 0,
            extensions: ["theme-white",  "effect-listitems-slide",  "border-offset"],
            navbars: [{
                height: 3,
                content: [
                    window.top_navbar
                ]
            }, true]
        }, {});
    var api = $("#menu").data("mmenu");
    api.bind("openPanel", function ($panel) {
        if($panel.attr("id")=='catalog-panel' || $panel.hasClass('mm-vertical')){
            $('body').addClass('catalog-opened');
        }else{
            $('body').removeClass('catalog-opened');
        }
    });
    $('.login-trigger').on('click',function(e){
        e.preventDefault();
        var api = $("#menu").data("mmenu");
        api.close();

        $('.auth-content').show();
        $('#page').hide();
        var state = 'sign-in-default-state';
        if(window.auth_type == 'email'){
            state = 'sign-in-email-state';
        }
        $('.header a').removeClass('opened').html('');
        setAuthState(state);
        $(window).scrollTop(0);
        return false;
    });
    $('#inp_agree').on('change',function(){
        var $form = $(this).closest('form');
        if($(this).is(':checked')){
            $form.find('button').removeAttr('disabled');
        }else{
            $form.find('button').attr('disabled','disabled');
        }
    });
    $('.auth-tabs li').on('click',function(e){
        e.preventDefault();
        var login_state = 'sign-in-default-state';
        if(window.auth_type == 'email'){
            login_state = 'sign-in-email-state';
        }
        var reg_state = 'sign-up-phone-state';
        if(window.auth_type == 'email'){
            reg_state = 'sign-up-email-state';
        }
        if($(this).attr('data-target') == 'sign-in'){
            setAuthState(login_state);
        }
        if($(this).attr('data-target') == 'sign-up'){
            setAuthState(reg_state);
        }
        $('.auth-tabs li').removeClass('active');
        $(this).addClass('active');

        return false;
    });
    $('.auth-state form').on('submit',function(e){
        e.preventDefault();
        var $form = $(this);
        if($('[name="PHONE"]').length>1 && $(this).find('[name="ACTION"]').val()!='RESET_PASSWORD'){
            $('[name="PHONE"]').val($form.find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');
        }
        if($('[name="EMAIL"]').length>1 && $(this).find('[name="ACTION"]').val()!='RESET_PASSWORD'){
            $('[name="EMAIL"]').val($form.find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
        }
        $('[name="PASSWORD"]').val($form.find('[name="PASSWORD"]').val()).closest('.bd-input').addClass('filled');

        if($(this).find('[name="ACTION"]').val()=='RESET_PASSWORD'){
            $('.phone-confirm-password-state').find('[name="PHONE"]').val($(this).find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');
            $('.set-new-password-state').find('[name="PHONE"]').val($(this).find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');

            $('.phone-confirm-password-state').find('[name="EMAIL"]').val($(this).find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
            $('.set-new-password-state').find('[name="EMAIL"]').val($(this).find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
        }

        $.ajax({
            type: 'post',
            data: $form.serialize(),
            dataType: "json",
            url: '?action=auth',
            success: function(data){
                $form.find('.bd-error').html('');
                if(data.ERRORS!=undefined){
                    $.each(data.ERRORS,function(i,item){
                        $form.find('input[name="'+item.FIELD+'"]').closest('.bd-input').addClass('error');
                        $form.find('.bd-error').append('<div>'+item.MESSAGE+'</div>');
                    });
                    var cont_ = '#sms_reg';
                    if($('#sms_reg').length == 0){
                        cont_ = '#sign-up-email-form';
                    }
                    if(
                        $(cont_+' .input-row-first .bd-input').hasClass('error') &&
                        $(cont_+' .input-row .bd-input').hasClass('error') &&
                        !$(cont_+' .input-row-last .bd-input').hasClass('error')
                    ){
                        $(cont_+' .input-row-last').css('margin-top',0);
                    }else{
                        $(cont_+' .input-row-last').css('margin-top','-1px');
                        $(cont_+' .input-row').css('margin-top','-1px');
                    }
                    if(
                        $(cont_+' .input-row-first .bd-input').hasClass('error') &&
                        !$(cont_+' .input-row .bd-input').hasClass('error') &&
                        $(cont_+' .input-row-last .bd-input').hasClass('error')
                    ){
                        $(cont_+' .input-row').css('margin-top',0);
                    }
                }else{
                    if(data.TYPE=='ERROR'){
                        $form.find('.bd-error').html(data.MESSAGE).show();
                    }else{
                        if(data.next!=='auth-success'){
                            $('.auth-state').hide();
                            $('.auth-state.'+data.next+'-state').show();
                            $form.find('.bd-error').html('').hide();
                        }else{
                            window.location.reload();
                        }
                    }
                }
            }
        })
        return false;
    })
    if($('.resend-cont').length){
        $('.code-resend').on('click',function(e){
            e.preventDefault();

            var $cont = $(this).closest('.auth-info');

            $.ajax({
                type: 'post',
                data:{ACTION: 'RESEND',PHONE: $cont.closest('.auth-state').find('input[name="PHONE"]').val()},
                dataType: "json",
                url: '?action=auth',
                success: function(data){
                    $cont.find('.resend-status').show();
                    $cont.find('.code-resend').hide();
                    $cont.find('.resend-status .timer').html('0:59');
                    var seconds = 59;
                    var interval = setInterval(function() {
                        seconds--;
                        $cont.find('.resend-status .timer').html('0:' + (seconds).pad());
                        if (seconds == 0){
                            clearInterval(interval);
                            $cont.find('.resend-status').hide();
                            $cont.find('.code-resend').show();
                        }
                    }, 1000);
                }
            })

            return false;
        });
    }
    var constructorIngredientBasketTemplate = '<div class="row constructor-ingredient-basket-item"  data-id="${ID}" data-auto="${IS_AUTO}"> ' +
        '<div class="name-cont"> ' +
        '<div class="name">${NAME}</div> ' +
        '<div class="category">${SECTION}</div> ' +
        '<div class="weight"><span>${GRAMM}</span> '+BX.message('gramm')+'</div> ' +
        '</div> ' +
        '<div class="buttons"><a href="#" class="change-amount-btn minus">-</a><span class="amount">${AMOUNT}</span> ' +
        '<input type="hidden" name="ING_AMOUNT[${ID}]" value="${AMOUNT}"/>' +
        '<a href="#" class="change-amount-btn plus">+</a> ' +
        '</div> ' +
        '<div class="price-block"><span class="product-sum">${LOCAL_PRICE}<span class="currency">'+window.currencyFont+'</span></span></div> ' +
        '<div class="remove-basket-item"  data-id="${ID}"><a href="#"> ' +
        '<svg viewBox="0 0 38.0919 40.5429"><path class="cls-1" d="M35.1491,39.3951V60.8883a6.2561,6.2561,0,0,0,6.2366,6.2366H59.81a6.2549,6.2549,0,0,0,6.2366-6.2366V39.3951H35.1491ZM57.8477,31.016c-0.5913-5.912-13.9111-5.912-14.5019,0H33.838a2.2942,2.2942,0,0,0-2.2875,2.2868h0A2.2939,2.2939,0,0,0,33.838,35.59H67.3556a2.2938,2.2938,0,0,0,2.2868-2.2875h0a2.2941,2.2941,0,0,0-2.2868-2.2868h-9.508ZM43.9426,60.6523c-0.8815,0-1.5868-.3957-1.5868-0.89V45.9838c0-.4947.7053-0.8907,1.5868-0.8907s1.587,0.396,1.587.8907v13.778c0,0.4947-.7053.89-1.587,0.89h0Zm6.6539,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778c0,0.4947-.7053.89-1.5868,0.89h0Zm6.6551,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778C58.8383,60.2565,58.133,60.6523,57.2515,60.6523Z" transform="translate(-31.5505 -26.5819)"/></svg></a></div> </div>';
    $.template( "constructorIngredientBasketTemplate", constructorIngredientBasketTemplate );
    var basketTemplate = '<div class="basket-item row ${CLASSES}"  data-pid="${ID}" data-id="${INDEX}" data-price="${PRICE}"> ' +
        '<div class="product-image-cont"> ' +
        '<div class="product-image"><img src="${IMAGE}"><div class="${APPEND_WITHOUT_SALE}" title="'+BX.message('gramm')+'"></div></div> ' +
        '</div> ' +
        '<div class="name-cont"> ' +
        '<div class="name">${NAME}</div> ' +
        '<div class="section">${SECTION}</div>'+
        '<div class="buttons"><a href="#" class="change-amount-btn minus">-</a><span class="amount">${AMOUNT}</span> ' +
        '<input type="hidden" value="${AMOUNT}"><a href="#" class="change-amount-btn plus">+</a> ' +
        '</div> ' +
        '</div> ' +
        '<div class="remove-basket-item"><span>&times;</span></div> ' +
        '<div class="price-block"><span class="product-sum font-fix"><span>${LOCAL_SUM}</span><span class="currency">'+window.currencyFont +'</span></span></div> ' +
        '</div> <div class="clearfix"></div>';
    $.template( "basketTemplate", basketTemplate );
    window.default_title = $('.header .title span').text();
    $('.use-bonuses button').on('click',function(e){
        $(this).closest('.use-bonuses').find('.bd-input').show();
    })
    $('.header a').on('click',function(e){
       if($("#menu").hasClass('mm-opened')){
           $('.mm-panels').hide();
           api.close();
           $('.header a').removeClass('opened').html('');
           $('.header .title img').show()
           $('.header .title span').hide();

           $('.header .title span').text(window.default_title).show();
       }else{
           $('.mm-panels').show();
           api.open();
           $('.header a').addClass('opened').html('&times;');
           $('.header .title img').hide();
           $('.header .title span').text(BX.message('mob_menu')).show();
            if($('.basket').is(':visible')){
                $('.basket-toggle').trigger('click');
            }
       }
    });

    if($('.main-tabs').length){
        $('.product-list').hide();
        $('.product-list.'+$('.main-tabs li.active a').data('target')).show();
        $('.main-tabs li').on('click',function(e){
            e.preventDefault();
            $('.main-tabs li').removeClass('active');
            $(this).addClass('active');
            $('.product-list').hide();
            $('.product-list.'+$(this).find('a').data('target')).show();
            return false;
        })
    }
    $('.basket-toggle').on('click',function(e){
        $('.header a').removeClass('opened').text('')
        e.preventDefault();
        api.close();
        $(window).scrollTop(0);
        if(parseInt($('.basket-header-sum span').first().text())!==0){
            if(!$('.basket.basket-p').is(':visible') && $(this).hasClass('active_')){
                backToBasket();
                $('.basket-header-sum').hide();
                $('.close-basket').show();
                $('.basket-toggle').removeClass('active_');
                $('.basket').show();
                $('#page').hide();
                $('.header .title span').text(BX.message('mob_basket')).show();
                $('.header .title img').hide();

            }else{
                $('.basket-toggle').addClass('active_');
                $('.basket-header-sum').show();
                $('.close-basket').hide();
                $('.basket.basket-p').hide();
                $('#page').show();
                $('.header .title span').text(window.default_title).show();
                $('.header .title img').show();
            }
        }
    });
    $('.new-address-view input').on('keyup',function(){
        validateAddress();
    });
    $('.apply-code-btn').on('click',function(e){
        checkPromoAjax();
        return false;
    })

    $('.gender-toggle a').on('click',function(){
        $('.gender-toggle a').removeClass('active');
        $(this).addClass('active');
        $('[name="USER[GENDER]"]').val($(this).attr('id'));
    });

    //sod
    $("select").selectOrDie({placeholderOption:true});
    //filter
    if($('.filter-btn').length){
        $('.filter-btn').on('click',function(e){
            e.preventDefault();
            $(this).toggleClass('active');
            $('.filter-cont').slideToggle(1);
            $('.product-list').slideToggle(1);
        })

    }
    if($('.filter-param-item').length){
        $('.filter-param-item .icon-param,.filter-param-item span').on('click',function(e){
            e.preventDefault();
            var $parent = $(this).parent();
            var $param = $(this).closest('.filter-param-item');
            var $form = $('#ingridients-filter form');
            if(!$(this).hasClass('selected')){
                $param.find('.icon-param').removeClass('selected');
                $(this).addClass('selected');
                $param.find('input[type="hidden"]').val('Y');
                if($(this)[0].tagName=='SPAN'){
                    $param.find('.add_param').addClass('selected');
                }
                if($(this).hasClass('remove-param')){
                    $param.find('input[type="hidden"]').val('E');
                    $param.find('span').removeClass('checked');
                    $param.find('span').addClass('unchecked');
                }else{
                    $param.find('input[type="hidden"]').val('Y');
                    $param.find('span').removeClass('unchecked');
                    $param.find('span').addClass('checked');
                }
            }else{
                $param.find('input[type="hidden"]').val('N');
                $(this).removeClass('selected');
                if($(this)[0].tagName=='SPAN'){
                    $param.find('.add_param').removeClass('selected');
                }
                $param.find('span').removeClass('unchecked');
                $param.find('span').removeClass('checked');
            }
            smartFilter.click($param.find('input[type="hidden"]')[0]);
            return false;
        });
        $('.apply-filter').on('click',function(e){
            $('.clear-filter-btn').show();
            $('.ingridients-filter-btn').addClass('active');
        });
        $('.clear-filter-btn,.clear-filter').on('click',function(e){
            $('.clear-filter-btn').hide();
            $('.ingridients-filter-btn').removeClass('active');
            $('.icon-param').removeClass('selected');
            $('.unchecked').removeClass('unchecked');
            $('.checked').removeClass('checked');
        });
    }
    //gifts
    if($('.gift-item').length){
        $('.get-gift').on('click',function(e){
            $(this).closest('.gift-list').find('.gift-item').removeClass('active');
            $(this).closest('.gift-item').addClass('active');
        });
    }
    //constructor
    if($('.base-item').length){
        $('.base-item').on('click',function(e){
            $(this).closest('.items-list').find('.base-item').removeClass('active');
            $(this).addClass('active');
        });
    }
    //checkout
    if($('.delivery-type-toggle').length>0){
        $('.delivery-type-toggle a').on('click',function(e){
            e.preventDefault();
            $('.delivery-type-toggle a').removeClass('active');
            $('[name="ORDER[DELIVERY_TYPE]"]').val($(this).data('type'));
            $('.dt_cont_d').hide();
            $('.dt_cont_d.delivery_time_cont_'+$(this).data('type')).show();
            $(this).addClass('active');
            $('.delivery-type-content > div').hide()
            $('.delivery-type-tab-'+$(this).data('type')).show();
            $.ajax({
                type: 'post',
                data: {TYPE: $(this).data('type')},
                dataType: "json",
                url: '/bitrix/components/bd/checkout_pizza/component.php?action=checkPickupDiscount',
                success: function(data){
                    renderBasket();
                }
            });
        });
    }
    if($('.delivery-time-type-toggle').length>0){
        $('.delivery-time-type-toggle a').on('click',function(e){
            e.preventDefault();
            $('.delivery-time-type-toggle a').removeClass('active');
            $(this).addClass('active');
            $('[name="ORDER[DELIVERY_TIME_TYPE]"]').val($(this).data('type'))
            if($(this).data('type')==2){
                $('.delivery-time-cont').show();
            }else{
                $('.delivery-time-cont').hide();
            }
        });
    }
    if($('.bd-row-checkbox').length){
        $('.bd-row-checkbox').on('click',function(e){
            if(!$(this).hasClass('multi'))
                $(this).closest('.checkboxes-mobile').find('.bd-row-checkbox').removeClass('active');

            if(!$(this).hasClass('active')){
                $('input[name="'+$(this).data('target')+'"]').val(1);
                $(this).addClass('active');
            }else{
                $('input[name="'+$(this).data('target')+'"]').val(0);
                $(this).removeClass('active');
            }

        });
    }
    $('.address-item').on('click',function(e){
        $('.status-bar .title').text($(this).data('target-title'));
        if(!$(this).hasClass('dis')){
            e.preventDefault()
            var $self = $(this)
            $.ajax({
                type: 'get',
                data: {'ID': $self.attr('data-id')},
                dataType: "json",
                url: '?action=getAddress',
                success: function(data){
                    var $cont = $('.profile-view.address-view');
                    $cont.find('input[name="ADDRESS[ID]"]').val(data.ID);
                    $cont.find('input[name="ADDRESS[NAME]"]').val(data.NAME);
                    $cont.find('input[name="ADDRESS[STREET]"]').val(data.STREET);
                    $cont.find('input[name="ADDRESS[HOUSE]"]').val(data.HOUSE);
                    $cont.find('input[name="ADDRESS[APARTMENT]"]').val(data.APARTMENT);
                    $cont.find('[name="ADDRESS[DISTRICT_ID]"]').val(data.DISTRICT_ID);
                    $('.address-view .dis').text($('.bd-row-checkbox[data-id="'+data.DISTRICT_ID+'"]').text());
                    $('.bd-row-checkbox[data-id="'+data.DISTRICT_ID+'"]').addClass('active');

                    $('.profile-view.personal-view').hide();
                    $('.profile-view.address-view').show();
                    $('.status-bar .back').attr('onclick','getProfileView("personal")')
                    //$('.back:visible').trigger('click');
                }
            });

            return false;
        }
    });

    $('.districts-view .bd-row-checkbox').on('click',function(e){
        $('.address-view [name="ADDRESS[DISTRICT_ID]"]').val($(this).attr('data-id'));
        $('.address-view .dis').text($(this).text());
        $('.back:visible').trigger('click');
        validateOrder();
    });
    $('.set-pickup-view .bd-row-checkbox').on('click',function(e) {
        e.preventDefault();
        $('[name="ORDER[DELIVERY_PICKUP_ID]"]').val($(this).attr('data-id'));
        $('.delivery-type-tab-2 .config-item a').text($(this).text())
        $('.map-row').show();
        myMap.setCenter(window['myPlacemark_'+$(this).attr('data-id')].geometry.getCoordinates(), 16, {duration: 1000})
        validateOrder();
    });
    $('.delivery-regions-view .bd-row-checkbox').on('click',function(e){
        e.preventDefault();
        $('.delivery-regions-view .bd-row-checkbox').removeClass('active');

        $(this).addClass('active');

        $('.new-address-view [name="ORDER[DISTRICT_ID]"]').val($(this).attr('data-id'));
        $('.new-address-view .config-item a').text($(this).text());

        $.ajax({
                type: 'post',
                data: {ID: $('.delivery-regions-view .bd-row-checkbox.active').attr('data-id')},
                dataType: "json",
                url: '/bitrix/components/bd/checkout_pizza/component.php?action=calculateDelivery',
                success: function(data){
                    $('.delivery-price').show();
                    $('.fields-group.delivery-price').show();
                    if(data.DELIVERY_PRICE>0){
                        $('._delivery-price-value').text(data.DELIVERY_PRICE);
                        $('._with-price').show();
                        $('._without-price').hide();
                        $('.delivery-price  .progress-container').show();
                        $('.delivery-price .progress-container .progress-bar').css('width',data.BASKET_SUM/data.FREE_DELIVERY*100+'%');
                        $('.delivery-price .progress-container .progress-bar-content').find('span').first().text(data.FREE_DELIVERY - data.BASKET_SUM)
                    }else{
                        $('.delivery-price  .progress-container').hide();
                        $('._with-price').hide();
                        $('._without-price').show();
                    }
                    renderBasket();
                    $('.back:visible').trigger('click');
                    validateOrder();
                    validateAddress();
                }
            });

    });
    $('.order-date-view .bd-row-checkbox').on('click',function(e){
        $('.delivery-time-cont .config-item a').text($(this).text())
        $('.delivery_time_cont_'+$('.delivery-type-toggle a.active').data('type')+' .config-item a').text($(this).text())
        if($('.delivery-type-toggle a.active').data('type') == 1){
        	$('[name="ORDER[DELIVERY_DATE]"]').val($(this).data('date'))
        }else{
	        $('[name="ORDER[DELIVERY_DATE_2]"]').val($(this).data('date'))
        }
        $('.back:visible').trigger('click');

        validateOrder();
    })
    $('.payment-type-view .bd-row-checkbox').on('click',function(e){
        e.preventDefault();

        $('[name="ORDER[PAYMENT_TYPE]"]').val($(this).attr('data-id'));
        $('.payment-type-ci a').text($(this).text());

        $('[name="ORDER[PAY_IDENT]"]').val($(this).data('type'));
        if($(this).data('change')=='Y'){
            $('._change_row').show();
        }else{
            $('._change_row').hide();
        }
        if($(this).data('type')=='offline'){
            $('.send-order').text(BX.message('submit_order'));
        }else{
            $('.send-order').text(BX.message('pay_order'));
        }
        $('.back:visible').trigger('click');
        validateOrder();

    });
    if($('input[name="ORDER[DISCOUNT_BONUSES]"]').length){
        $('input[name="ORDER[DISCOUNT_BONUSES]"]').on('change',function(){
            var $self = $(this);
            $.ajax({
                type: 'post',
                data: {AMOUNT: $self.val()},
                dataType: "json",
                url: '/bitrix/components/bd/checkout_pizza/component.php?action=calculateBonuses',
                success: function(data){
                    if(data.status!=0)
                        $('input[name="ORDER[DISCOUNT_BONUSES]"]').val(data.status);
                    renderBasket();
                }
            });
        });
    }
    $('#checkout-form').on('submit',function(e){
        var $form = $(this);
        e.preventDefault();
        $.ajax({
            type: 'post',
            data: $form.serialize(),
            dataType: "json",
            url: '/bitrix/components/bd/checkout_pizza/component.php?action=validate',
            success: function(data){
                if(data.status==0){
                    $('.bd-input,.sod_select').removeClass('error shake');
                    $('.config-item').removeClass('error');
                    $('.bd-input').removeClass('error');
                    $.each(data.errors,function(i,item){
                        if(item == 'DISTRICT_ID' || item == 'STREET' || item == 'HOUSE' || item == 'APARTMENT'){
                            $('.delivery-type-tab-1 .config-item').last().addClass('error');
                        }
                        if(item == 'PAYMENT_TYPE'){
                            $('.payment-type-ci').addClass('error')

                        }
                        if(item == 'DELIVERY_PICKUP_ID'){
                            $('.delivery-type-tab-2 .config-item').addClass('error')
                        }
                        if(item == 'USER_NAME'){
                            $('[name="ORDER[USER_NAME]"').parent().addClass('error');
                        }
                        if(item == 'USER_PHONE'){
                            $('[name="ORDER[USER_PHONE]"').parent().addClass('error');
                        }

                    });

                    setTimeout(function(){$(window).scrollTop($('#checkout-form').find('.error').first().offset().top-52);}, 500);
                }else{
                    if(window.yaCounter!=undefined && window.yaCounter != null){
                        yaCounter.reachGoal('order-submit',{});
                    }
                    if(ga!=undefined){
                        ga('send', 'event', 'order', 'submit');
                    }
                    $form[0].submit()
                }
            }
        });
    });
    $('.ingredient-list-view .bd-row-checkbox').on('click',function(e){
        if($(this).hasClass('active')){
	        if($('input[name="INGREDIENTS[]"][value="'+$(this).data('id')+'"]').length == 0){
	            $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="'+$(this).data('id')+'"/>');
	        }
	        if($('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]')){
	            $('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]').remove();
            }

        }else{
            removeFromConstructor($(this).data('id'));
        }
        calculateConstructor();
    });
    $('.add-ingredient-view .config-item a').on('click',function(e){
        $('.ingredient-list-view .bd-row-checkbox').hide()
        $('.ingredient-list-view .bd-row-checkbox[data-section="'+$(this).data('id')+'"]').show();
        $('.status-bar .title').text($(this).text());
        $('.back').attr('onclick',"getConstructorView('add-ingredient')").attr('href','#');
    });
    $('.my-adresses-view .bd-row-checkbox').on('click',function(e){
        e.preventDefault();

        $('[name="ORDER[DISTRICT_ID]"]').val($(this).data('district'));

        $('.delivery-regions-view .bd-row-checkbox[data-id="'+$(this).data('district')+'"]').trigger('click');

        if($(this).data('street').length)
            $('[name="ORDER[STREET]"]').val($(this).data('street'));

        if($(this).data('house').toString().length)
            $('[name="ORDER[HOUSE]"]').val($(this).data('house'));

        if($(this).data('apartment').toString().length)
            $('[name="ORDER[APARTMENT]"]').val($(this).data('apartment'));

        $('.delivery-type-tab-1 .config-item a').text($(this).data('street')+BX.message('homee')+$(this).data('house')+BX.message('appartaments')+$(this).data('apartment'));
        $('.checkout-view.new-address-view button').removeAttr('disabled');
		$('.back:visible').trigger('click');
    });
    $('.presets-view .base-item').on('click',function(){
        $('input[name="INGREDIENTS[]"]').remove();
        $('#constructor_form input[name="NAME"]').val($(this).find('.name').text());
        $('#constructor_form input[name="IMAGE"]').val($(this).data('big-image'));
        $('.constructor-ingredient-basket-item').remove();
        $(this).closest('.select-preset-list').find('.preset-item').removeClass('active');
        $(this).addClass('active');

        $('.constructor-main-image img').attr('src',$(this).data('big-image'));
        var ids = $(this).data('filling').split(',');
        $.each(ids,function (i, item) {
            $('.ingredient-item[data-id="'+item+'"]').addClass('active')
            if($('input[name="INGREDIENTS[]"][value="'+item+'"]').length == 0){
                $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="'+item+'"/>');
            }
        });
        $('[data-var-name="'+$(this).attr('data-var')+'"]').text($(this).find('.name').text());
        calculateConstructor();
        $('.back:visible').trigger('click');
    })
    $('.constructor-view.base-view .base-item,.constructor-view.souse-view .base-item').on('click',function(){
        $('[name="'+$(this).data('target')+'"]').val($(this).data('id'));
        $('[data-var-name="'+$(this).attr('data-var')+'"]').text($(this).find('.name').text());
        calculateConstructor();
        $('.back:visible').trigger('click');
    })
    $('.save-address').on('click',function(e){
        e.preventDefault();
        $.ajax({
            type: 'post',
            data: $('.address-view form').serialize(),
            dataType: "json",
            url: '/?action=updateAddress',
            success: function(data){
                window.location.reload();
            }
        });
        return false;
    });
    if($('.get-gift').length){
        $('.get-gift').on('click',function(e){
            e.preventDefault();
            var $self = $(this).closest('.gift-item');
            if(!$(this).hasClass('get-another-gift')){
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': $self.data('id'),IS_GIFT: 1,GIFT_LIMIT: $self.data('limit')},
                dataType: "json",
                url: '/include/ajax1/basket.php?action=addToBasket',
                success: function(data){
                    renderBasket();
                    if(data.basket_sum!=undefined){
                        $self.addClass('active');
                        $('.gift-item').addClass('masked');
                        $('.gift-item[data-id="'+$self.data('id')+'"]').removeClass('masked');
                        $self.find('button').addClass('get-another-gift').text(BX.message('get_another_clear'));
                    }else{
                        alert(BX.message('good_luck_bitch'))
                    }
                    $('.gift-progress-complete').addClass('reuse');
                }
            });
            }else{
                $.ajax({
                    type: 'post',
                    data: {'PRODUCT_ID': $self.data('id'), IS_GIFT: 1},
                    dataType: "json",
                    url: '/include/ajax1/basket.php?action=removeGift',
                    success: function (data) {
                        renderBasket();
                        if (data.basket_sum != undefined) {
                            $self.removeClass('active');
                            $('.gift-item').removeClass('masked');
                            $('.get-gift').removeClass('get-another-gift').text(BX.message('choise'));
                        }
                    }
                });
            }
        });
        $('.get-another-gift').on('click',function(e){
            e.preventDefault();
            var $self = $(this).closest('.gift-item');
            if($(this).hasClass('get-another-gift')) {

            }
            $('.gift-progress-complete').removeClass('reuse');
        });
    }
});
(function(){
    var ajaxPagerLoadingClass   = 'ajax-pager-loading',
        ajaxPagerWrapClass      = 'ajax-pager-wrap',
        ajaxPagerLinkClass      = 'ajax-pager-link',
        ajaxWrapAttribute       = 'wrapper-class',
        ajaxPagerLoadingTpl     = ['<span class="' + ajaxPagerLoadingClass + '">',
            '',
            '</span>'].join(''),
        busy = false,


        attachPagination = function (wrapperClass){
            var $wrapper = $('.' + wrapperClass),
                $window  = $(window);

            if($wrapper.length && $('.' + ajaxPagerWrapClass).length){
                $window.on('scroll', function() {
                    if(($window.scrollTop() + $window.height()) >
                        ($wrapper.offset().top + $wrapper.height() - 400) && !busy) {
                        busy = true;
                        $('.' + ajaxPagerLinkClass).click();
                    }
                });
            }
        },

        ajaxPagination = function (e){
            e.preventDefault();

            busy = true;
            var wrapperClass = $('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute),
                $wrapper = $('.' + wrapperClass),
                $link = $(this);

            if($wrapper.length){
                $('.' + ajaxPagerWrapClass).append(ajaxPagerLoadingTpl);
                $.get($link.attr('href'), {'AJAX_PAGE' : 'Y'}, function(data) {
                    $('.' + ajaxPagerWrapClass).remove();

                    $wrapper.append($(data).filter('.product-ajax-cont'));
                    $wrapper.append($(data).find('.product-ajax-cont'));
                    $wrapper.append($(data).filter('.news-item'));
                    $wrapper.append($(data).find('.news-item'));
                    $wrapper.append($(data).filter('.ajax-pager-wrap'));
                    $wrapper.append($(data).find('.ajax-pager-wrap'));

                    setTimeout(function(){
                        $wrapper.find('.product-ajax-cont').removeClass('animate');
                    },1000);
                    setTimeout(function () {
                        var t_ = data.split('</html>');
                        if(t_[1]!==undefined && t_[1]!==null){
                            if($(t_[1]).html()!==undefined){
                                var script = $(t_[1]).html().replace(new RegExp('%26AJAX_PAGE%3DY','g'),'');
                                script = script.replace(new RegExp('&AJAX_PAGE%3DY','g'),'');
                                script = script.replace(new RegExp('PAGEN_[0-9][0-9]%3D[0-9]','g'),'');
                                script = script.replace(new RegExp('PAGEN_[0-9]%3D[0-9]','g'),'');
                                eval(script);
                            }
                        }
                    },1000)

                    attachPagination(wrapperClass);
                    registerProductListeners();
                    registerLikes();
                    $("select").selectOrDie({placeholderOption:true});



                    busy = false;
                });
            }
        };

    $(function() {
        if($('.'+ajaxPagerLinkClass).length
            && $('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute).length){
            attachPagination($('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute));
            $(document).on('click', '.' + ajaxPagerLinkClass, ajaxPagination);
        }
    });
})();
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD (Register as an anonymous module)
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {},
            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling $.cookie().
            cookies = document.cookie ? document.cookie.split('; ') : [],
            i = 0,
            l = cookies.length;

        for (; i < l; i++) {
            var parts = cookies[i].split('='),
                name = decode(parts.shift()),
                cookie = parts.join('=');

            if (key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

}));