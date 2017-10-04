<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php if($_SESSION['BASKET_SUM'] > 0): ?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
	ymaps.ready(init);
	var myMap;

	function init(){
		myMap = new ymaps.Map("map", {
			center: [<?php echo $arResult["TAKE_AWAY"][0]['COORDINATE']; ?>],
			zoom: 16
		});

		<?php foreach($arResult["TAKE_AWAY"] as $ta_item): ?>
			window.myPlacemark_<?php echo $ta_item['ID'] ?> = new ymaps.Placemark([<?php echo $ta_item['COORDINATE']; ?>], {
				hintContent: '<?php echo $ta_item['NAME']; ?>',
				balloonContent: '<?= GetMessage("checkout_take_away_address"); ?>: <?php echo $ta_item['NAME']; ?> <br /> <?= GetMessage("checkout_take_away_phone"); ?>: <?php echo $ta_item['PHONE']; ?> <br /> <?= GetMessage("checkout_take_away_email"); ?>: <?php echo $ta_item['EMAIL']; ?> <br /> <?= GetMessage("checkout_take_away_work_time"); ?>: <?php echo $ta_item['WORK_TIME']; ?>'
			});

			myMap.geoObjects.add(window.myPlacemark_<?php echo $ta_item['ID'] ?>);
		<?php endforeach; ?>
	}
</script>
  <div class="status-bar" style="display: none;">
    <a href="#" class="back"></a>
    <div class="title"></div>
  </div>
 <div class="checkout">
   <form action="" method="post" id="checkout-form">
          <div class="checkout-view main-view">
            <div class="checkout-label client-info"><?= GetMessage("checkout_personal_title"); ?></div>
            <div class="bd-input top-border-fix">
              <input type="text" name="ORDER[USER_NAME]" class="text-xs-left" placeholder="<?= GetMessage("checkout_personal_name"); ?>" value="<?php echo (!empty($arResult['USER']['NAME']))?$arResult['USER']['NAME']:''; ?>">
            </div>
            <div class="bd-input">
              <input name="ORDER[USER_PHONE]" autocomplete="off" type="tel" class="text-xs-left" placeholder="<?= GetMessage("checkout_personal_phone"); ?>" value="<?php echo (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!=='7')?$arResult['USER']['PHONE']:''; ?>">
            </div>
            <div class="delivery-type-cont">
	            <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED','',SITE_ID) == 'Y'): ?>
              <div class="delivery-type-toggle font-fix"><a href="#" data-type="1" <?php if(!isset($_SESSION['USE_PICKUP_DISCOUNT']) || $_SESSION['USE_PICKUP_DISCOUNT']==0): ?>class="active"<?php endif; ?>><?= GetMessage("checkout_delivery_type_courier"); ?></a><a href="#" data-type="2" <?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>class="active"<?php endif; ?>><?= GetMessage("checkout_delivery_type_take_away"); ?></a></div>
              <?php endif; ?>
              <input type="hidden" name="ORDER[DELIVERY_TYPE]" value="<?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>2<?php else: ?>1<?php endif; ?>"/>
              <div class="delivery-type-content <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED','',SITE_ID) !== 'Y'): ?>without-pickup<?php endif; ?>">
                <div <?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>style="display: none;" <?php endif; ?> class="delivery-type-tab-1">
	                <?php if(!empty($arResult['ADDRESSES'])): ?>
                  <div class="checkout-label"><?= GetMessage("checkout_delivery_my_adress"); ?></div>
                  <div class="config-item"><a href="#" onclick="getCheckoutView('my-adresses')"><?= GetMessage("checkout_delivery_take_away_address"); ?></a></div>
                  <?php endif; ?>
                  <div class="checkout-label new-address-label"><?= GetMessage("checkout_address_delivery"); ?></div>
                  <div class="config-item"><a href="#" onclick="getCheckoutView('new-address')"><?= GetMessage("checkout_edit_address_delivery"); ?></a></div>
                </div>
                <div style="display: none;" class="delivery-type-tab-2">
                  <div class="checkout-label"><?= GetMessage("checkout_delivery_take_away_where"); ?></div>
                  <div class="config-item"><a href="#" onclick="getCheckoutView('set-pickup')"><?= GetMessage("checkout_delivery_take_away_address"); ?></a></div>
                </div>
              </div>
            </div>
            <?php  if($USER->IsAuthorized() && \COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
            <div class="checkout-label my-bonuses-label"><?= GetMessage("checkout_bonus_title"); ?></div>
            <div class="use-bonuses">
              <button type="button"><?= GetMessage("checkout_bonus_pay"); ?></button>
              <div class="user-balance"><?= GetMessage("checkout_bonus_have_1"); ?>
					<?php echo number_format($_SESSION['BONUS_VALUE'],0 ,'.',' ');; ?><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("checkout_bonus_have_2"); ?></div>
              <div class="bd-input" style="display: none;">
	              <input type="number" placeholder="<?= GetMessage("bonuses_sum"); ?>" name="ORDER[DISCOUNT_BONUSES]">
              </div>
            </div>
            <?php endif; ?>
            <div class="checkout-label my-bonuses-label"><?= GetMessage("checkout_pay_method"); ?></div>
            <div class="config-item payment-type-ci"><a href="#" onclick="getCheckoutView('payment-type')"><?= GetMessage("checkout_delivery_choice"); ?></a></div>
            <input type="hidden" name="ORDER[PAYMENT_TYPE]"/>
            <input type="hidden" name="ORDER[PAY_IDENT]"/>
            <input type="hidden" name="ORDER[DELIVERY_PICKUP_ID]"/>
            <input type="hidden" name="ORDER[DELIVERY_TIME_TYPE]" value="0"/>
            <input type="hidden" name="ORDER[DELIVERY_DATE]" />
            <input type="hidden" name="ORDER[DELIVERY_DATE_2]" />
            <div class="bd-input _change_row" style="display: none;">
              <input type="text" name="ORDER[ODD_MONEY]" placeholder="<?= GetMessage("checkout_pay_deposit"); ?>">
            </div>
            <div class="checkout-label"><?= GetMessage("checkout_delivery_time"); ?></div>
            <div class="delivery_time_cont_1 dt_cont_d">
	            <div class="delivery-time-type-toggle font-fix"><a href="#" data-type="0" class="active"><?= GetMessage("checkout_delivery_this"); ?></a><a href="#" data-type="1"><?= GetMessage("checkout_delivery_to"); ?></a></div>
	            
	            <div style="display: none;" class="delivery-time-cont">
	              <div class="config-item"><a href="#" onclick="getCheckoutView('order-date')"><?= GetMessage("checkout_delivery_to_date"); ?></a></div>
	              <div class="bd-input">
	                <input type="text" name="ORDER[DELIVERY_TIME]" class="delivery_time" maxlength="5" placeholder="<?= GetMessage("checkout_delivery_to_time"); ?>">
	              </div>
	            </div>
            </div>
            <div class="delivery_time_cont_2 dt_cont_d" style="display: none;">
	            <div class="config-item"><a href="#" onclick="getCheckoutView('order-date')"><?= GetMessage("checkout_delivery_to_date"); ?></a></div>
              <div class="bd-input">
                <input type="text" name="ORDER[DELIVERY_TIME_2]" class="delivery_time" maxlength="5" placeholder="<?= GetMessage("checkout_delivery_to_time"); ?>">
              </div>
            </div>
            <div class="checkout-footer">
              <div class="delivery-price" style="display: none;"><label
                    class="text-xs-center delivery-price-label font-fix _with-price"><?= GetMessage("checkout_price_delivery"); ?>
                  <span class="_delivery-price-value"></span><span
                      class="currency"><?=CURRENCY_FONT; ?></span></label>
                <label class="text-xs-center delivery-price-label font-fix _without-price" style="display: none"><?= GetMessage("checkout_free_delivery"); ?><br></label>
                <div class="clear"></div>
                <div style="display: none;" class="progress-container font-fix">
                  <div class="progress-bar"></div>
                  <div class="progress-bar-content">
                    <div></div>
                    <span></span><span
                        class="currency"><?=CURRENCY_FONT; ?></span><?= GetMessage("checkout_price_delivery_for_free"); ?>
                  </div>
                </div>
              </div>

              <div class="order-total-container">
                <div class="order-total">
                  <div class="order-sum checkout-sum font-fix"><span></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                  <div class="order-discount"><?=GetMessage("BASKET_SALE");?> <span></span>%</div>
                </div>
              </div>
             <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID)=='Y'): ?>
				<?php if($USER->IsAuthorized()): ?>
                 <div class="bonuses-info">
                   <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_NOT_APPEND_BONUSES_PROMO','',SITE_ID)=='Y'): ?>
                 <div class="bonuses-with-promo-disabled"><?= GetMessage("checkout_no_bonuses"); ?></div>
                   <?php endif; ?>
                   <div class="default-text checkout-default-text">
                     <?= GetMessage("checkout_total_bonus_1"); ?>
                     <span></span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("checkout_total_bonus_2"); ?>
                   </div>
                   
                 </div>
					<?php else: ?>
					<div class="bonuses-info">
						<div class="default-text checkout-default-text">
							<?= GetMessage("checkout_total_bonus_3"); ?>
						</div>
					</div>
				<?php endif; ?>
			  <?php endif; ?>
              <div class="checkout-cont">
                <button type="submit" class="send-order"><?= GetMessage("checkout_submit"); ?></button>
              </div>
            </div>
          </div>
          <div style="display: none" class="checkout-view new-address-view">
            <div class="checkout-label"><?= GetMessage("checkout_delivery_destrict"); ?></div>
            <div class="config-item"><a href="#" onclick="getCheckoutView('delivery-regions')"><?= GetMessage("checkout_delivery_choice"); ?></a></div>
            <div class="checkout-label mbfix"><?= GetMessage("checkout_delivery_address"); ?></div>
            <input type="hidden" name="ORDER[DISTRICT_ID]"/>
            <div class="bd-input first">
              <input type="text" name="ORDER[STREET]" placeholder="<?= GetMessage("checkout_delivery_street"); ?>">
            </div>
            <div class="bd-input">
              <input type="text" name="ORDER[HOUSE]" placeholder="<?= GetMessage("checkout_delivery_home"); ?>">
            </div>
            <div class="bd-input">
              <input type="text" name="ORDER[APARTMENT]" placeholder="<?= GetMessage("checkout_delivery_room"); ?>">
            </div>
            <div class="checkout-footer">
              <button type="button" onclick="processAddress();" disabled="disabled"><?= GetMessage("address_button_save"); ?></button>
            </div>
          </div>
          <div style="display: none" class="checkout-view payment-type-view">
            <div class="checkboxes-mobile">
	            <input type="hidden" name="ORDER[PAY_IDENT]"/>
			<? foreach ($arResult["PAYSYS"] as $PAYSYS): ?>
              <div class="bd-row-checkbox" data-type="<?php echo $PAYSYS['IDENT_PAY']; ?>" data-change="<?php echo $PAYSYS['CHANGE']; ?>"  data-id="<?= $PAYSYS['ID'] ?>">
                <input type="hidden"><span><?=$PAYSYS['NAME'] ?></span>
                <div class="base-image">
                  <div class="image checkout_ico_checked">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
              </div>
              <? endforeach; ?>
            </div>
          </div>																			
          <div style="display: none" class="checkout-view delivery-regions-view">
	          <? foreach ($arResult["DESTRICT"] as $key => $DESTRICT): ?>
            <div class="checkboxes-mobile">
              <div class="bd-row-checkbox" data-id="<?= $DESTRICT['ID'] ?>">
                <span><?= $DESTRICT['NAME'] ?></span>
                <div class="base-image">
                  <div class="image checkout_ico_checked">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
              </div>
            </div>
            <? endforeach; ?>
          </div>
          <div style="display: none" class="checkout-view my-adresses-view">
            <div class="checkboxes-mobile">
				<?php foreach ($arResult['ADDRESSES'] as $address): ?>
              <div class="bd-row-checkbox"
                   data-name="<?php echo $address['NAME']; ?>"
                   data-street="<?php echo $address['STREET']; ?>"
                   data-district="<?php echo $address['DISTRICT_ID']; ?>"
                   data-house="<?php echo $address['HOUSE']; ?>"
                   data-apartment="<?php echo $address['APARTMENT'];?>">
                <span><?php echo $address['NAME']; ?></span>
                <div class="base-image">
                  <div class="image checkout_ico_checked">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div style="display: none" class="checkout-view set-pickup-view">
            <div class="checkboxes-mobile">
			<? foreach ($arResult["TAKE_AWAY"] as $TAKE_AWAY): ?>
              <div class="bd-row-checkbox"  data-coordinate="<?php echo $TAKE_AWAY['COORDINATE']; ?>" data-id="<?= $TAKE_AWAY['ID'] ?>">
                <span><?= $TAKE_AWAY['NAME'] ?></span>
                <div class="base-image">
                  <div class="image checkout_ico_checked">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
              </div>
            <? endforeach; ?>  
              <div class="map-row">
	              <div id="map"></div>
              </div>
            </div>
          </div>
          <div style="display: none" class="checkout-view order-date-view">
            <div class="checkboxes-mobile">
			<? $iteration = 3;
												if(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '0' || \COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == ''){
												 $time = time();
												}else{
													$time = strtotime(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID).' hour');
												} for ($i=0;$i<=$iteration;$i++){ ?>
              <div class="bd-row-checkbox"  data-date="<?php echo FormatDate("d",$time+($i*86400)); ?>">
                <span><?php echo FormatDate("j F",time()+($i*86400)); ?></span>
                <div class="base-image">
                  <div class="image checkout_ico_checked">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
              </div>
            <? } ?>

            </div>
          </div>
   </form>
        </div>
        
<?php else: ?>
	<main class="content container">
		<div class="content-page page-404 font-fix empty-items">
			<div class="status-title"><?= GetMessage("checkout_empty_basket"); ?></div>
		</div>
	</main>
<?php endif; ?>        