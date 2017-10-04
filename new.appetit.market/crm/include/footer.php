<?php
use Bd\Deliverypizza;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<div class="order-preview">
	<div class="spinner"></div>
	<form id="order_form">
		<input type="hidden" value="" name="ID"/>
		<input type="hidden" value="" name="USER_ID"/>
		<input type="hidden" value="" name="DISCOUNT"/>
		<input type="hidden" value="" name="DISCOUNT_BONUSES"/>
		<div class="wrap">
			<div class="close-window"><?php echo GetMessage("close"); ?></div>
			<div class="row">
				<div class="customer-information">
					<div class="customer-information__status"><?php echo GetMessage("new"); ?></div>
					<div class="customer-information__body">
						<div class="customer-information__client">
							<div class="customer-information__client-head row">
								<div class="title"><?php echo GetMessage("client"); ?></div>
								<div class="num"><span></span><a href="#"></a></div>
							</div>
							<div class="form">
								<div class="row row-margin">
									<div class="col-my-6">
										<div class="bd-input">
											<label><?php echo GetMessage("name"); ?></label>
											<input type="text" name="USER_NAME">
										</div>
									</div>
									<div class="col-my-6">
										<div class="bd-input">
											<label><?php echo GetMessage("phone"); ?></label>
											<input type="text" name="USER_PHONE">
										</div>
									</div>
								</div>
							</div>
						</div><!-- .customer-information__client -->
						<div class="customer-information__delivery">
							<div class="title"><?php echo GetMessage("delivery_info"); ?></div>
							<ul class="delivery-select">
								<li class="delivery-select__item courier active" data-type="1"><?php echo GetMessage("currier"); ?></li>
								<li class="delivery-select__item himself" data-type="2"><?php echo GetMessage("take_away"); ?></li>
							</ul>
							<div class="delivery-options active">
								<div class="form">
									<div class="form-ln">
										<select class="basic" name="DISTRICT_ID" data-placeholder-option="true">
											<option value="null"><?php echo GetMessage("destrict"); ?></option>
											<?php foreach($districts as $district): ?>
												<option data-price="<?=$district['DELIVERY_PRICE']?>" data-free="<?=$district['FREE_DELIVERY']?>" value="<?=$district['ID'];?>"><?=$district['NAME'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="row row-margin form-ln">
										<div>
											<div class="bd-input street-field">
												<label><?php echo GetMessage("street"); ?></label>
												<input type="text" name="STREET">
											</div>
										</div>
									</div>
									<div class="row row-margin form-ln">
										<div class="col-my-6">
											<div class="bd-input">
												<label><?php echo GetMessage("home"); ?></label>
												<input type="text" name="HOUSE">
											</div>
										</div>
										<div class="col-my-6">
											<div class="bd-input">
												<label><?php echo GetMessage("appartaments"); ?></label>
												<input type="text" name="APARTMENT">
											</div>
										</div>
									</div>
									<div class="form-ln">
										<div class="bd-input textarea">
											<label><?php echo GetMessage("order_comment"); ?></label>
											<textarea rows="5" cols="5" name="COMMENT"></textarea>
										</div>
									</div>

								</div>
							</div>
							<input type="hidden" name="DELIVERY_TYPE" value="">
							<div class="delivery-options">
								<div class="form">
									<div class="form-ln">
										<select class="basic" name="DELIVERY_PICKUP_ID" data-placeholder-option="true">
											<option value="null"><?php echo GetMessage("where_get"); ?></option>
											<?php foreach($pickups as $pickup): ?>
												<option value="<?=$pickup['ID'];?>"><?=$pickup['NAME'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-ln">
										<div class="bd-input textarea">
											<label><?php echo GetMessage("order_comment"); ?></label>
											<textarea rows="5" cols="5" name="COMMENT2"></textarea>
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" name="DELIVERY_TIME_TYPE" value="" />
							<a href="#" class="time_type_toggle"><?php echo GetMessage("change_time"); ?></a>
							<div class="row row-margin form-ln time_config">
								<div class="col-my-6">
									<div class="bd-input">
										<label
											class="text-xl-center"><?php echo GetMessage("time"); ?></label>
										<input name="DELIVERY_TIME" type="text">
									</div>
								</div>
								<div class="col-my-6">
									<select class="basic" name="DELIVERY_DATE" data-placeholder-option="true">
										<option value=""><?php echo GetMessage("date"); ?></option>
										<?php
										$iteration = 3;
										for ($i=0;$i<=$iteration;$i++){
											?>
											<option data-valued="<?php echo FormatDate("j",time()+($i*86400)); ?>" value="<?php echo FormatDate("j F",time()+($i*86400)); ?>"><?php echo FormatDate("j F",time()+($i*86400)); ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="customer-information__payment">
							<div class="title"><?php echo GetMessage("pay_info"); ?></div>
							<div class="form">
								<div class="form-ln">
									<select class="basic" name="PAYMENT_TYPE" data-placeholder-option="true">
										<option value="null"><?php echo GetMessage("pay_method"); ?></option>
										<?php foreach($payments as $payment): ?>
											<option data-change="<?=$payment['CHANGE']?>" value="<?=$payment['ID'];?>"><?=$payment['NAME'];?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-ln">
									<div class="bd-input short_change">
										<label><?php echo GetMessage("check"); ?></label>
										<input type="text" name="ODD_MONEY">
									</div>

									<div class="payment-status paid"><?php echo GetMessage("order_payed"); ?></div>
									<div class="payment-status not-paid"><?php echo GetMessage("order_not_payed"); ?></div>
								</div>
							</div>
						</div>
						<div class="customer-information__promokod">
							<div class="form">
								<div class="row form-ln">
									<div class="bd-input">
										<label><?php echo GetMessage("promo"); ?></label>
										<input readonly type="email" name="PROMO_CODE">
									</div>
								</div>

							</div>
						</div>
						<div class="customer-information__control">
							<div class="customer-information__control-bt"><a href="" target="_blank" class="print-bt"><?php echo GetMessage("print"); ?></a></div>
							<div class="customer-information__control-bt"><input type="submit" class="save-bt save-order-data" value="<?php echo GetMessage("save"); ?>"></div>
						</div>
					</div>
				</div><!-- .customer-information -->
				<div class="order-info">
					<div class="order-info__head row">
						<div class="order-info__head-left">
							<div class="order-num"><?php echo GetMessage("order"); ?> #<span class="order_num_value"></span>  <span class="date"></span></div>
							<div class="source-order"><?php echo GetMessage("source_order"); ?> <span></span></div>
						</div>
						<div class="order-info__head-right">
							<div class="order-info__title"><?php echo GetMessage("status_order"); ?></div>
							<div class="order-info__select">
								<select class="basic" name="STATUS" data-placeholder-option="true">
									<option value="null"><?php echo GetMessage("choise"); ?></option>
									<option value="1"><?php echo GetMessage("treated"); ?></option>
									<option value="6"><?php echo GetMessage("kitchen"); ?></option>
									<option value="8"><?php echo GetMessage("currier"); ?></option>
									<option value="7"><?php echo GetMessage("delivery"); ?></option>
									<option value="2"><?php echo GetMessage("fail"); ?></option>
								</select>
							</div>
						</div>
					</div><!-- .order-info__head -->
					<div class="order-list">
						<div class="order-list__title"><?php echo GetMessage("order_consist"); ?></div>
						<div class="order-list__content"></div>
						<input type="button" class="add-bt" value="<?php echo GetMessage("add"); ?>" onclick="createProduct()">
					</div><!-- .order-list -->
					<div class="order-rezult">
						<p class="order_sum_value"><?php echo GetMessage("order_summ"); ?>  <b><span></span><span class="currency"><?=CURRENCY_FONT?></span></b></p>
						<p class="delivery_price_value"><?php echo GetMessage("delivery_price"); ?>  <b><span></span><span class="currency"><?=CURRENCY_FONT?></span></b></p>
						<p class="promo_code_discount_value"><?php echo GetMessage("discount_promo"); ?> <b><span></span></b></p>
						
						<p class="bonuses_used_value"><?php echo GetMessage("bonuses_payed"); ?>  <b><span></span><span class="currency"><?=CURRENCY_FONT?></span></b></p>
						<p class="bonuses_append"><input type="hidden" name="BONUSES_APPEND" /><?php echo GetMessage("bonuses_append"); ?>  <b><span></span><span class="currency"><?=CURRENCY_FONT?></span></b></p>
						<p class="pickup_discount"><?php echo GetMessage("discount_take_away"); ?>  <b><span></span>%</b></p>
						<div class="itogo"><p><?php echo GetMessage("summ"); ?> <span></span><span class="currency"><?=CURRENCY_FONT?></span></p></div>
					</div>
				</div><!-- .order-info -->
			</div>
			<input type="hidden" name="ORDER_SUM">
			<input type="hidden" name="DELIVERY_PRICE">
		</div>
	</form>
</div>
<div class="client-preview">
	<div class="spinner"></div>
	<div class="wrap">
		<div class="close-window"><?php echo GetMessage("close"); ?></div>
		<div class="data-client-info row">
			<div class="data-client-info__col-20">
				<div class="data-box data-box--registration-source">
					<div class="title"></div>
					<p><?php echo GetMessage("source_registr"); ?></p>
				</div>
			</div>
			<div class="data-client-info__col-20">
				<div class="data-box data-box--latest-order">
					<div class="title"></div>
					<p><?php echo GetMessage("date_last_order"); ?></p>
				</div>
			</div>
			<div class="data-client-info__col-20">
				<div class="data-box data-box--orders">
					<div class="title"></div>
					<p><?php echo GetMessage("ordero"); ?></p>
				</div>
			</div>
			<div class="data-client-info__col-20">
				<div class="data-box data-box--total-spent">
					<div class="title"><span></span><span class="currency"><?=CURRENCY_FONT?></span></div>
					<p><?php echo GetMessage("summ_spend"); ?></p>
				</div>
			</div>
			<div class="data-client-info__col-20">
				<div class="data-box data-box--spent-bonus">
					<div class="title"><span></span><span class="currency"><?=CURRENCY_FONT?></span></div>
					<p><?php echo GetMessage("bonuses_spend"); ?></p>
				</div>
			</div>
			<div class="data-client-info__scale">
				<div class="counts">
					<div class="summa"> <span></span><span class="currency"><?=CURRENCY_FONT?></span></div>
					<p><?php echo GetMessage("counts"); ?></p>
				</div>
				<ul class="sale-scale">
					<li class="p10"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_CASHBACK', '', SITE_ID); ?>%</li>
					<li class="p7"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_CASHBACK', '', SITE_ID); ?>%</li>
					<li class="p5"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_CASHBACK', '', SITE_ID); ?>%</li>
				</ul>
				<div class="balance">
					<div class="not-max">
						<p><?php echo GetMessage("remainded"); ?> <span></span><span class="currency"><?=CURRENCY_FONT?></span></p>
						<p><?php echo GetMessage("bonuses_discount_to"); ?></p>
					</div>
					<div class="is-max">
						<p><?php echo GetMessage("bonuses_discount_max"); ?></p>
					</div>
				</div>
			</div>
			<div class="data-client-info__vip">
				<div class="data-client-info__vip-text">
					<div class="title"><?php echo GetMessage("status_vip"); ?></div>
					<p><?php echo GetMessage("status_vip_text"); ?></p>
				</div>
				<div class="data-client-info__vip-icon"></div>
			</div>
		</div><!-- .data-client-info -->
		<div class="row row-margin">
			<div class="client-shot-info col-my-6">
				<div class="client-shot-info__title"><?php echo GetMessage("client"); ?></div>
				<div class="row row-margin-10">
					<div class="col-my-6">
						<div class="bd-input">
							<label><?php echo GetMessage("name"); ?></label>
							<input type="text" name="NAME">
						</div>
					</div>
					<div class="col-my-6">
						<div class="bd-input">
							<label><?php echo GetMessage("phone"); ?></label>
							<input type="text" name="PHONE">
						</div>
					</div>
					<div style="margin-top: 10px;clear: both;"></div>
					<div class="col-my-6">
						<div class="bd-input">
							<label><?php echo GetMessage("email"); ?></label>
							<input type="text" name="EMAIL">
						</div>
					</div>
					<div class="col-my-6">
						<div class="bd-input">
							<label><?php echo GetMessage("birthday_date"); ?></label>
							<input type="text" name="BIRTHDAY">
						</div>
					</div>
				</div>
				<div class="el_chek-out notify-config">
					<input type="hidden" name="NOTIFY_SMS" value="0">
					<input type="hidden" name="NOTIFY_EMAIL" value="0">
					<div class="el_chek"><label><input type="checkbox" name="sms_notify" data-target="NOTIFY_SMS" /><b><?php echo GetMessage("get_sms"); ?></b></label></div>
					<div class="el_chek"><label><input type="checkbox" name="email_notify" data-target="NOTIFY_EMAIL" /><b><?php echo GetMessage("get_email"); ?></b></label></div>
				</div>
				<button class="save-user-data"><?php echo GetMessage("save"); ?></button>
			</div><!-- .client-shot-inf -->
			<div class="client-shot-address col-my-6">
				<div class="client-shot-address__title"><?php echo GetMessage("address"); ?></div>
				<div class="address-list"></div>
			</div><!-- .client-shot-address -->
		</div>
		<div class="orders-statistics">
			<div class="orders-statistics__title"><?php echo GetMessage("order_statistic"); ?></div>
			<div class="orders-statistics__table"><div id="chart"></div></div>
		</div><!-- .orders-statistics -->
		<div class="row">
			<div class="orders-history">
				<div class="orders-history__title"><?php echo GetMessage("order_history"); ?></div>
				<div class="orders-list">
				</div>
			</div>
			<div class="favorite-foods">
				<div class="favorite-foods__title"><?php echo GetMessage("love_item"); ?></div>
				<div class="favorite-foods-list"></div>
			</div>
		</div>
	</div>
</div>
<div style="display: none;">
	<div id="sms-decline-popover">
	<div class="title"><?php echo GetMessage("fail_sms"); ?></div>
	<div class="desc"><?php echo GetMessage("fail_sms_text"); ?></div>
	</div>
	<div id="sms-accept-popover">
		<div class="send-state">
		<form action="">
			<input type="hidden" name="USER_ID"/>
			<input type="hidden" name="ORDER_ID"/>
			<div class="title"><?php echo GetMessage("send_sms_title"); ?></div>
			<input type="text" placeholder="<?php echo GetMessage("phone"); ?>" readonly name="PHONE"/>
			<select name="TEMPLATE" class="basic" data-placeholder-option="true">
				<option value="null"><?php echo GetMessage("get_sms_template"); ?></option>
				<?php foreach($smsTemplates as $key => $template): ?>
					<option data-template="<?=$template['TEMPLATE']?>" value="<?=$key?>"><?=$template['NAME'];?></option>
				<?php endforeach; ?>
			</select>
			<textarea name="MESSAGE" placeholder="<?php echo GetMessage("sms_text"); ?>"></textarea>
			<button disabled type="button" class="send-sms-button"><?php echo GetMessage("send_sms"); ?></button>
		</form>
		</div>
		<div class="sent-state">
			<div class="success-text"><?php echo GetMessage("sms_send_complete"); ?>
                        <div class="success-icon">
                          <svg viewBox="0 0 500 500"><path d="M 207.375,425.00c-10.875,0.00-21.175-5.075-27.775-13.825L 90.25,293.225c-11.625-15.35-8.60-37.20, 6.75-48.825 c 15.375-11.65, 37.20-8.60, 48.825,6.75l 58.775,77.60l 147.80-237.275c 10.175-16.325, 31.675-21.325, 48.025-11.15 c 16.325,10.15, 21.325,31.675, 11.125,48.00L 236.975,408.575c-6.075,9.775-16.55,15.90-28.025,16.40C 208.425,425.00, 207.90,425.00, 207.375,425.00z"></path></svg>
                        </div>
                      </div>
		</div>
		<div class="not-sent-state">
						<div class="error-text"><?php echo GetMessage("sms_send_error"); ?>
                        <div class="error-icon">
                          <svg viewBox="0 0 500 500"><path d="M 207.375,425.00c-10.875,0.00-21.175-5.075-27.775-13.825L 90.25,293.225c-11.625-15.35-8.60-37.20, 6.75-48.825 c 15.375-11.65, 37.20-8.60, 48.825,6.75l 58.775,77.60l 147.80-237.275c 10.175-16.325, 31.675-21.325, 48.025-11.15 c 16.325,10.15, 21.325,31.675, 11.125,48.00L 236.975,408.575c-6.075,9.775-16.55,15.90-28.025,16.40C 208.425,425.00, 207.90,425.00, 207.375,425.00z"></path></svg>
                        </div>
                      </div>
		</div>
	</div>
</div>
<?	
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/jquery.uniform.min.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/selectordie.min.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/tmpl.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/alertify.min.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/maskedinput.min.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/popover.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/favico-0.3.10.min.js');
	$APPLICATION->AddHeadScript(SITE_DIR.'crm/static/js/script.js');
?>