<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<div class="cart_popup animate_in" id="cart" style="display:none;">
	<div class="podarok_complete hidden_" style="display: none;">
			<a href="/menu/gifts/" class="pd"><?=GetMessage("GIFT_OTHER");?></a>
        </div>
    	<div class="podarok hidden_" style="display: none;">        	
			<a href="/menu/gifts/" class="pd"><?=GetMessage("GIFT");?></a>
        </div>
        <div class="empty_podarok" style="display: block;">
	        <div class="padding">        	
			<span class="l1"><?=GetMessage("IF_U_SPEND");?></span><br>
			<span class="l2"><span class="need_to_gift">0</span> <i class="rouble rouble_padding">i</i></span><br>
			<span class="l3"><?=GetMessage("U_GET_GIFT");?></span>
			</div>
        </div>
        <div class="bd">
    	<span class="close"></span>
        <div class="title"><?=GetMessage("BASKET_TITLE");?></div>        
        <div id="scrollbar1">
        	<?php $frame = $this->createFrame("scrollbar1", false)->begin(); 
	        	  $frame->setBrowserStorage(true);
        	?>
        	
            <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
            <div class="viewport">
                 <div class="overview"> 
	                 <div class="cart_spinner spinner"></div>        
                    <ul class="zakaz_list">        
                    </ul>
                </div>
            </div>
            <?php $frame->end(); ?>
        </div>
        <div class="cart_meta">
        	<div class="mleft">
                <p><?=GetMessage("PROMO_DESCRIPTION");?></p>
                <input type="text" maxlength="8" class="promo_value" value="" placeholder="<?=GetMessage("INPUT_PROMO");?>">
                
        	</div>
            <div class="mright">
            	<div class="cena">
                <p class="itogo"><?=GetMessage("BASKET_SUMM");?>:</p>
                <div class="summa"><span></span> <i class="rouble rouble_padding">i</i></div>
                <div class="discount_notice" style="display:none"><?=GetMessage("BASKET_SALE");?> <span class="discount_value"></span>%</div>
                </div>
                <input type="submit" class="" value="<?=GetMessage("BASKET_BUTTON");?>">
                <?php if($arParams['SHOP_MIN_SUMM']!==''): ?>
                <script type="text/javascript">
	                window.shop_min_sum = '<?php echo $arParams['SHOP_MIN_SUMM']; ?>';
                </script>
                <div class="not_enough" style="display:none"><?=GetMessage('MIN_PRICE_TEXT');?> <span><?php echo $arParams['SHOP_MIN_SUMM']; ?></span> <i class="rouble rouble_padding">i</i></div>
                <?php endif; ?>
        	</div>
        </div>
        </div>
    </div><!-- #cart -->
    <div class="cart_popup" id="oform" style="display:none;">
    <?php $frame = $this->createFrame("oform", false)->begin(); 
	      $frame->setBrowserStorage(true);
    ?>
    	<span class="close"></span>
        <a href="#" class="back_to_cart"><?=GetMessage("BACK_TO_BASKET");?></a>
        <div class="title"><span><?=GetMessage("ORDER_TITLE_BSC");?></span></div>
        <div class="surely"><?=GetMessage("IMPORTANT_TITLE");?><i>*</i></div>
		<form class="order_form_fields">  
			<input type="hidden" class="basket_total" value=""/>      
        	<div class="ln">
                <span class="txt"><?=GetMessage("ORDER_NAME");?><i>*</i></span>
                <input type="text" class="rt required user_name" value="" placeholder="">
            </div>
        	<div class="ln">
                <span class="txt"><?=GetMessage("ORDER_PHONE");?><i>*</i></span>
                <input type="text"  maxlength="16" class="rt phone required" value="" placeholder="+7 ___ ___ __ __">
            </div> 
            <div class="ln">
                <span class="txt"><?=GetMessage("ORDER_EMAIL");?>&nbsp;&nbsp;</span>
                <input type="text" class="rt order_email" value="" placeholder="">
            </div> 
        	<div class="ln">
                <span class="txt"><?=GetMessage("ORDER_DESTRICT");?><i>*</i></span>
				<select class="chosen-select-no-single style_hosen1 required delivery_list">
					<?foreach ($arResult["DESTRICT"] as $key=>$DESTRICT):?>
				<option value="<?=$DESTRICT['ID']?>" data-delivery-name="<?=$DESTRICT['NAME']?>" data-delivery-price="<?=$DESTRICT['DELIVERY_PRICE']?>" data-free-delivery="<?=$DESTRICT['FREE_DELIVERY']?>" data-time-delivery="<?=$DESTRICT['TIME_DELIVERY']?>"><?=$DESTRICT['NAME']?></option>
                    <?endforeach;?>                                       
				</select>
            </div>
            <div class="ln">
                <span class="txt"><?=GetMessage("ADRESS_DELIVERY");?><i>*</i></span>
                <textarea class="required user_address" style="resize: none;" rows="5" cols="5" placeholder="<?=GetMessage("DELIVERY_PLACEHOLDER");?>"></textarea>
            </div>
            <div class="ln">
            	<span class="txt"><?=GetMessage("NUMBER_PERSON");?></span>
 				<div class="colich_tov">
					<input type="button" value="-" class="minus_tov" />
                    <input type="text" value="1" class="txt_col_tov persons" />
                    <input type="button" value="+" class="plus_tov" />
				</div>
            </div>    
            <?if($arParams['PAY_ON'] == "Y"):?>
                <div class="ln">
                <span class="txt"><?=GetMessage("PAY_ORDER");?><i>*</i></span>
				<select class="chosen-select-no-single style_hosen1 payment_type">
					<?foreach ($arResult["PAYSYS"] as $PAYSYS):?>
					<option value="<?=$PAYSYS['IDENT_PAY']?>"><?=$PAYSYS['NAME']?></option>
                    <?endforeach;?>                                                
				</select>                
            </div>            
            <?endif;?>
            <div class="ln need_short_change_container" style="display: none;">
                <span class="txt"><?=GetMessage("SDACHA");?></span>
                <input type="text" class="rt  need_short_change" value="" placeholder="">
            </div>
            <div class="delivery_price">
	            <div class="delivery_with_price"><?=GetMessage("DELIVERY_COST");?>: <span><span class="delivery_price_value"><?php echo $arResult["DESTRICT"][0]['DELIVERY_PRICE'] ?></span> <i class="rouble rouble_padding">i</i></span></div>
	            <div class="delivery_free" style="display: none;"><?=GetMessage("FREE_DELIVERY");?></div>

	            </div>
            <div class="clear"></div>
            <div class="of_meta">
                <input type="submit" class="send_order_btn" value="<?=GetMessage("ORDER_BUTTON");?>">
                <div class="summa"><span></span><i class="rouble">i</i></div>                 
                <p class="itogo"><?=GetMessage("ORDER_SUMM");?>:</p>     
            </div>         
		</form> 
		<?php $frame->end(); ?>
    </div><!-- #oform -->    
    <div class="panda_popup" id="thank" style="display:none;">
        <span class="close"></span>
        <div class="inf">
            <div class="title"><?=GetMessage("THANKS_TITLE");?></div>
            <p><?=GetMessage("THANKS_DESC");?></p>
        </div>
        <div class="panda"></div>
    </div><!-- #thank -->
    <div class="panda_popup" id="paid" style="display:none;">
        <span class="close"></span>
        <div class="inf">
            <div class="title"><?=GetMessage("PAY_COMPLETE_TITLE");?></div>
            <p><?=GetMessage("PAY_COMPLETE_DESC");?></p>
        </div>
        <div class="panda"></div>    
    </div><!-- #paid -->
    <div class="panda_popup" id="error" style="display:none;">
        <span class="close"></span>
         <div class="inf" style="margin: 29px 0 0 53px;">
            <div class="title"><?=GetMessage("PAY_FAIL_TITLE");?></div>
            <p style="width: 278px;"><?=GetMessage("PAY_FAIL_DESC");?></p>
        </div>
        <div class="panda"></div>   
    </div><!-- #error -->
    <?php  if($arParams['PAY_ON']=='Y'): ?>
    	<?php
	    	$mrh_login = $arParams['ROBOKASSA_IDENT'];
			$mrh_pass1 = $arParams['ROBOKASSA_PASS_1'];
			$inv_id = intval($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]); 
			$inv_desc = GetMessage("PAY_ROBOKASSA_DESC");
			$out_summ = 0; 
			$crc = md5($mrh_login.":".$out_summ.":".$inv_id.":".$mrh_pass1);		    	
			
	    ?>
	    <form action="<?php if($arParams['PAY_TEST_MODE']=='Y'): ?><?php else: ?>https://merchant.roboxchange.com/Index.aspx<?php endif; ?>" method="post" class="payment_form">
		    <input type="hidden" class="login_rb" name="MrchLogin" value="<?=$mrh_login?>">
		    <input type="hidden" class="pass_rb" name="MrchPass" value="<?=$mrh_pass1?>">
			<input type="hidden" class="out_sum" name="OutSum" value="<?=$out_summ?>">
			<input type="hidden" class="id_rb" name="InvId" value="<?=$inv_id?>">
			<input type="hidden" class="desc_eb" name="Desc" value="<?=$inv_desc?>">
			<input type="hidden" class="crc" name="SignatureValue" value="<?=$crc?>">
	    </form>
		
    <?php endif; ?>