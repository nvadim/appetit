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
<div class="checkout-form">
	<form id="checkout-form" method="post">
		<input type="hidden" name="CSRF" value=""/>
		<div class="col-lg-8 col-xl-8 col-sm-12 col-md-8 col-xs-12 pull-xs-left delivery-col">
			<div class="row fields-group">
				<div class="row-label"><?= GetMessage("checkout_personal_title"); ?></div>
				<div class="row fields">
					<div class="col-lg-4 col-xl-4 col-sm-4 col-xs-6">
						<div class="bd-input <?php if(!empty($arResult['USER']['NAME'])): ?>filled<?php endif; ?>">
							<label class="text-xl-center"><?= GetMessage("checkout_personal_name"); ?></label>
							<input type="text" name="ORDER[USER_NAME]" class="text-xs-left" value="<?php echo (!empty($arResult['USER']['NAME']))?$arResult['USER']['NAME']:''; ?>">
						</div>
					</div>
					<div class="col-lg-4 col-xl-4 col-sm-4 col-xs-6 nopadl">
						<div class="bd-input <?php if(!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!=='7'): ?>filled<?php endif; ?>">
							<label class="text-xl-center"><?= GetMessage("checkout_personal_phone"); ?></label> 
							<input name="ORDER[USER_PHONE]"  autocomplete="off" type="text" class="text-xs-left" value="<?php echo (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!=='7')?$arResult['USER']['PHONE']:''; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="row fields-group">
				<div class="row-label font-fix"><?= GetMessage("checkout_delivery_title"); ?></div>
				<div class="row fields">
					<div class="col-xs-12">
						<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED','',SITE_ID) == 'Y'): ?>
						<div class="delivery-type-toggle font-fix">
							<a href="#" data-type="1" <?php if(!isset($_SESSION['USE_PICKUP_DISCOUNT']) || $_SESSION['USE_PICKUP_DISCOUNT']==0): ?>class="active"<?php endif; ?>><?= GetMessage("checkout_delivery_type_courier"); ?></a><a href="#" data-type="2" <?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>class="active"<?php endif; ?>><?= GetMessage("checkout_delivery_type_take_away"); ?></a>

						</div>
						<?php endif; ?>
						<input type="hidden" name="ORDER[DELIVERY_TYPE]" value="<?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>2<?php else: ?>1<?php endif; ?>"/>
						<div class="delivery-type-content <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED','',SITE_ID) !== 'Y'): ?>without-pickup<?php endif; ?>">
							<div <?php if(isset($_SESSION['USE_PICKUP_DISCOUNT']) && $_SESSION['USE_PICKUP_DISCOUNT']>0): ?>style="display: none;" <?php endif; ?> class="delivery-type-tab-1">
								<?php if(!empty($arResult['ADDRESSES'])): ?>
								<div class="row">
									<div class="col-lg-4 col-xl-4 col-sm-6 col-xs-6">
										<select class="cs-select cs-skin-slide checkout-user-addresses">
											<option
												value="null"><?= GetMessage("checkout_delivery_my_adress"); ?></option>
											<?php foreach ($arResult['ADDRESSES'] as $address): ?>
												<option value="" data-street="<?php echo $address['STREET']; ?>"
												        data-district="<?php echo $address['DISTRICT_ID']; ?>"
												        data-house="<?php echo $address['HOUSE']; ?>"
												        data-apartment="<?php echo $address['APARTMENT']; ?>"><?php echo $address['NAME']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<?php endif; ?>
								<div class="row">
									<div class="col-lg-4 col-xl-4 col-sm-6 col-xs-6">
										<select name="ORDER[DISTRICT_ID]" class="cs-select cs-skin-slide">
											<option
												value="null"><?= GetMessage("checkout_delivery_destrict"); ?></option>
											<? foreach ($arResult["DESTRICT"] as $key => $DESTRICT): ?>
												<option value="<?= $DESTRICT['ID'] ?>"><?= $DESTRICT['NAME'] ?></option>
											<? endforeach; ?>
										</select>
									</div>
								</div>
								<div class="row _address_config">
									<div class="col-lg-4 col-xl-4 col-sm-4 col-xs-6">
										<div class="bd-input">
											<label
												class="text-xl-center"><?= GetMessage("checkout_delivery_street"); ?></label>
											<input name="ORDER[STREET]" type="text" class="text-xs-left">
										</div>
									</div>
									<div class="col-lg-2 col-xl-2 col-sm-2 col-xs-2">
										<div class="bd-input">
											<label
												class="text-xl-center"><?= GetMessage("checkout_delivery_home"); ?></label>
											<input name="ORDER[HOUSE]" type="text" class="text-xs-left">
										</div>
									</div>
									<div class="col-lg-2 col-xl-2 col-sm-2 col-xs-2">
										<div class="bd-input">
											<label
												class="text-xl-center"><?= GetMessage("checkout_delivery_room"); ?></label>
											<input name="ORDER[APARTMENT]" type="text" class="text-xs-left">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-8 col-xl-8 col-sm-8 col-xs-12">
										<div class="bd-input textarea">
											<label class="text-xl-center"><?= GetMessage("checkout_comment"); ?></label>
											<textarea name="ORDER[COMMENT]" type="text" class="text-xs-left"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div
										class="col-lg-12 col-xl-6 col-sm-12 col-xs-12 radios delivery-time-type_"><?= GetMessage("checkout_delivery_time"); ?>
										<label>
											<input type="radio" name="ORDER[DELIVERY_TIME_TYPE]" id="type_1" value="0"
											       checked>
											<label
												for="type_1"><span></span></label><span><?= GetMessage("checkout_delivery_this"); ?></span>
										</label>
										<label>
											<input type="radio" id="type_2" name="ORDER[DELIVERY_TIME_TYPE]" value="1">
											<label
												for="type_2"><span></span></label><span><?= GetMessage("checkout_delivery_to"); ?></span>
										</label>
									</div>
								</div>
								<div class="row">
									<div
										class="col-lg-8 col-xl-4 col-sm-8 col-xs-8 text-xs-right nopadl delivery-date-time_">
										<div class="col-xs-5 nopadl time-cont-r">
											<div class="bd-input">
												<label
													class="text-xl-center"><?= GetMessage("checkout_delivery_to_time"); ?></label>
												<input maxlength="5" type="text" name="ORDER[DELIVERY_TIME]" class="text-xs-left">
											</div>
										</div>
										<div class="col-xs-7 nopad text-xs-left">
											<select name="ORDER[DELIVERY_DATE]">
												<option value=""><?= GetMessage("checkout_change_date"); ?></option>
											<?php
												$iteration = 3;
												if(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '0' || \COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == ''){
												 $time = time();
												}else{
													$time = strtotime(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID).' hour');
												}
												for ($i=0;$i<=$iteration;$i++){
													?>
													<option value="<?php echo FormatDate("j F",time()+($i*86400)); ?>"><?php echo FormatDate("j F",$time+($i*86400)); ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_PICKUP_ENABLED','',SITE_ID) == 'Y'): ?>
							<div <?php if(!isset($_SESSION['USE_PICKUP_DISCOUNT']) || $_SESSION['USE_PICKUP_DISCOUNT']==0): ?>style="display: none;" <?php endif; ?> class="delivery-type-tab-2">
								<div class="row">
									<div class="col-lg-4 col-xl-4 col-sm-6 col-xs-6">
										<select name="ORDER[DELIVERY_PICKUP_ID]" class="cs-select cs-skin-slide">
											<option
												value="null"><?= GetMessage("checkout_delivery_take_away_where"); ?></option>
											<? foreach ($arResult["TAKE_AWAY"] as $TAKE_AWAY): ?>
												<option data-coordinate="<?php echo $TAKE_AWAY['COORDINATE']; ?>"
													value="<?= $TAKE_AWAY['ID'] ?>"><?= $TAKE_AWAY['NAME'] ?></option>
											<? endforeach; ?>
										</select>
									</div>
								</div>
								<div class="row map-row">
									<div class="col-lg-10 col-xl-10 col-sm-10 col-xs-12">
										<div class="map-placeholder">
											<div id="map"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-8 col-xl-8 col-sm-8 col-xs-12">
										<div class="bd-input textarea">
											<label class="text-xl-center"><?= GetMessage("checkout_comment"); ?></label>
											<textarea name="ORDER[COMMENT_2]" type="text" class="text-xs-left"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div
										class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-xs-3 select-time-title"><?= GetMessage("checkout_delivery_take_away_time"); ?></div>
									<div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-xs-7 nopad text-xs-right">
										<div class="col-xs-3 nopadl">
											<div class="bd-input">
												<label
													class="text-xl-center"><?= GetMessage("checkout_delivery_to_time"); ?></label>
												<input maxlength="5" name="ORDER[DELIVERY_TIME_2]" type="text" class="text-xs-left">
											</div>
										</div>
										<div class="col-xs-6 nopadl text-xs-left">
											<select name="ORDER[DELIVERY_DATE_2]">
												<option value=""><?= GetMessage("checkout_change_date"); ?></option>
												<?php
												$iteration = 3;
												if(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '0' || \COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == ''){
												 $time = time();
												}else{
													$time = strtotime(\COption::GetOptionString('bd.deliverypizza','BD_SITE_TIMEZONE_OFFSET', '', SITE_ID).' hour');
												}
												for ($i=0;$i<=$iteration;$i++){
													?>
													<option value="<?php echo FormatDate("j F",time()+($i*86400)); ?>"><?php echo FormatDate("j F",$time+($i*86400)); ?></option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-xl-4 col-sm-12 col-md-4 col-xs-12 payment-col pull-xs-right">

			<?php  if($USER->IsAuthorized() && \COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
			<div class="use-bonuses">
				<div class="bd-input">
					<label class="text-xl-center"><?= GetMessage("checkout_bonus_pay"); ?></label>
					<input type="text" name="ORDER[DISCOUNT_BONUSES]">
				</div>
				<div class="bonus-available font-fix text-xs-center"><?= GetMessage("checkout_bonus_have_1"); ?>
					<?php echo number_format($_SESSION['BONUS_VALUE'],0 ,'.',' ');; ?><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("checkout_bonus_have_2"); ?></div>
			</div>
			<?php endif; ?>
			<div class="payment-fields">
				<div class="row fields-group">
					<div class="row fields">
						<div class="col-xs-12">
							<input type="hidden" name="ORDER[PAY_IDENT]"/>
							<select name="ORDER[PAYMENT_TYPE]" class="cs-select cs-skin-slide">
								<option value="null"><?= GetMessage("checkout_pay_method"); ?></option>
								<? foreach ($arResult["PAYSYS"] as $PAYSYS): ?>
									<option data-type="<?php echo $PAYSYS['IDENT_PAY']; ?>" data-change="<?php echo $PAYSYS['CHANGE']; ?>"  value="<?= $PAYSYS['ID'] ?>"><?= $PAYSYS['NAME'] ?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row fields _change_row">
						<div class="col-xs-12">
							<div class="bd-input">
								<label class="text-xl-center"><?= GetMessage("checkout_pay_deposit"); ?></label>
								<input type="text" name="ORDER[ODD_MONEY]" class="text-xs-left">
							</div>
						</div>
					</div>
				</div>
				<div class="row fields-group delivery-price">
					<div class="row fields">
						<div class="col-xs-12">
							<div class="bd-input">
								<label
									class="text-xs-center delivery-price-label font-fix _with-price"><?= GetMessage("checkout_price_delivery"); ?>
									<span class="_delivery-price-value"></span><span
										class="currency"><?=CURRENCY_FONT; ?></span></label>
								<label class="text-xs-center delivery-price-label font-fix _without-price" style="display: none"><?= GetMessage("checkout_free_delivery"); ?></label>
							</div>
							<div style="display: none;" class="progress-container font-fix">
								<div class="progress-bar"></div>
								<div class="progress-bar-content">
									<div></div>
									<span></span><span
										class="currency"><?=CURRENCY_FONT; ?></span><?= GetMessage("checkout_price_delivery_for_free"); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row fields">
				<div class="payment-footer">
					<div class="total-row">
						<div class="col-xs-4 order-total-container nopadl">
							<div class="order-total">
								<div class="summary-label"><?= GetMessage("checkout_summ"); ?>:</div>
								<div class="order-sum font-fix"><span><?php echo $_SESSION['BASKET_SUM']; ?></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
								<div class="order-discount"><?= GetMessage("checkout_discount"); ?> <span><?php echo $_SESSION['DISCOUNT']; ?></span>%</div>
							</div>
						</div>
						<div class="col-xs-8 bonuses-info text-xs-left">
							<?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID)=='Y'): ?>
								<?php if($USER->IsAuthorized()): ?>
									<?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_NOT_APPEND_BONUSES_PROMO','',SITE_ID)=='Y'): ?>
										<div class="bonuses-with-promo-disabled"><?= GetMessage("checkout_no_bonuses"); ?></div>
									<?php endif; ?>
									<div class="default-text">
										<?= GetMessage("checkout_total_bonus_1"); ?>
										<span></span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("checkout_total_bonus_2"); ?>
									</div>
								<?php else: ?>
									<?= GetMessage("checkout_total_bonus_3"); ?>
								<?php endif; ?>
							<?php else: ?>
								<?= GetMessage("checkout_total_bonus_disabled"); ?>
							<?php endif; ?>
						</div>
						<button type="submit" class="send-order"><?= GetMessage("checkout_submit"); ?></button>
					</div>
				</div>
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