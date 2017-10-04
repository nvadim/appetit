<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="profile-view personal-view">
	<form action="" method="post">
		<input type="hidden" name="USER[ID]"  value="<?php echo $arResult['USER']['ID']; ?>">
            <div class="bd-input">
              <input type="text" name="USER[NAME]" placeholder="<?= GetMessage("profile_name"); ?>" value="<?php echo $arResult['USER']['NAME']; ?>">
            </div>
            <div class="bd-input">
              <input type="text" maxlength="10" name="USER[BIRTHDAY]" value="<?php echo $arResult['USER']['BIRTHDAY']; ?>" placeholder="<?= GetMessage("profile_birthday"); ?>">
            </div>
            <?php if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'sms'): ?>
            <div class="bd-input">
              <input type="text" name="USER[EMAIL]" value="<?php echo $arResult['USER']['EMAIL']; ?>" placeholder="<?= GetMessage("profile_email"); ?>">
            </div>
            <?php endif; ?>
            
            <?php  if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'email'): ?>
            <div class="bd-input">
              <input type="text" name="USER[PHONE]" value="<?php echo (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!==PHONE_CODE)?$arResult['USER']['PHONE']:''; ?>" placeholder="<?= GetMessage("profile_phone"); ?>">
            </div>
            <?php endif; ?>
            <div class="gender-toggle-cont">
	            <input type="hidden" name="USER[GENDER]" value="<?php echo $arResult['USER']['GENDER']; ?>"/>
              <div class="gender-toggle font-fix">
	              <a href="#" <?php if($arResult['USER']['GENDER']=='male'): ?>class="active"<?php endif; ?> name="time_type" id="male"><?= GetMessage("profile_man"); ?></a><a href="#" <?php if($arResult['USER']['GENDER']=='female'): ?>class="active"<?php endif; ?> name="time_type" id="female"><?= GetMessage("profile_women"); ?></a></div>
            </div>
            <div class="profile-phone-cont">
	          <?php if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'sms'): ?>
              <div class="phone-value"><?php echo $arResult['USER']['PHONE']; ?></div>
              <div class="phone-change"><?= GetMessage("profile_text_change_email"); ?> <?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE', '', SITE_ID) ?></div>
              <?php endif; ?>
              
              <?php  if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'email'): ?>
              <div class="phone-value"><?php echo $arResult['USER']['EMAIL']; ?></div>
              <div class="phone-change"><?= GetMessage("profile_text_change_email"); ?> <?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE', '', SITE_ID) ?></div>
              <?php endif; ?>
              <div class="checkboxes-mobile notify_checkbox">
                <div class="bd-row-checkbox multi <?=($arResult['USER']['NOTIFY_SMS']==1)?'active':'';?>" data-target="USER[NOTIFY_SMS]">
                  <div class="base-image base-img-profile">
                    <div class="image checkout_ico_checked">
                      <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                    </div>
                  </div>
                  <input type="hidden" name="USER[NOTIFY_SMS]" value="<?php echo $arResult['USER']['NOTIFY_SMS']; ?>"/>
                  <span><?= GetMessage("profile_get_sms"); ?></span>
                </div>
                <div class="bd-row-checkbox multi <?=($arResult['USER']['NOTIFY_EMAIL']==1)?'active':'';?>" data-target="USER[NOTIFY_EMAIL]">
                  <div class="base-image base-img-profile">
                    <div class="image checkout_ico_checked">
                      <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                    </div>
                  </div>
                  <input type="hidden" name="USER[NOTIFY_EMAIL]" value="<?php echo $arResult['USER']['NOTIFY_EMAIL']; ?>"/>
                  <span><?= GetMessage("profile_get_email"); ?></span>
                </div>
              </div>
            </div>
            <div class="checkout-label my-address-label"><?= GetMessage("profile_my_address"); ?></div>
			<?php foreach($arResult['USER']['ADDRESSES'] as $address): ?>
            <div class="config-item top-border-fix"><a class="address-item" href="#" data-id="<?=$address['ID']?>"  data-target-title="<?=$address['NAME']?>"><?=$address['NAME']?></a></div>
			<?php endforeach; ?>
            <div class="add-address-cont"><a href="#" onclick="getAddressForm()" class="add-address font-fix"><span><?= GetMessage("profile_add_adress"); ?></span></a></div>
            <div class="profile-footer">
              <button type="submit" class="save-profile"><?= GetMessage("profile_save"); ?></button>
            </div>
   </form>
</div>
<div class="profile-view districts-view" style="display: none;">
	<div class="checkboxes-mobile">
		<?php foreach($arResult["DESTRICT"] as $d): ?>
		<div class="bd-row-checkbox" data-id="<?php echo $d['ID']; ?>">
			<span><?php echo $d['NAME']; ?></span>
			<div class="base-image">
				<div class="image checkout_ico_checked">
					<svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"></path></svg>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<div class="profile-view address-view" style="display: none;">
	<form action="" method="post">
		<input type="hidden" name="ADDRESS[ID]"  value="">
		<div class="bd-input">
			<input type="text" name="ADDRESS[NAME]" placeholder="<?= GetMessage("profile_address_name"); ?>" value="">
		</div>
		<input type="hidden" name="ADDRESS[DISTRICT_ID]"  value="">
		<label class="bd-form-label"><strong><?=GetMessage('destrict_areas');?></strong></label>
		<div class="config-item top-border-fix"><a class="address-item dis" href="#" onclick="getProfileView('districts')" data-target-title="<?= GetMessage("destrict_areas"); ?>"><?=GetMessage('profile_destrict')?></a></div>

		<label class="bd-form-label"><strong><?=GetMessage('profile_address_label');?></strong></label>
		<div class="bd-input">
			<input type="text" name="ADDRESS[STREET]" placeholder="<?= GetMessage("profile_street"); ?>" value="">
		</div>
		<div class="bd-input">
			<input type="text" name="ADDRESS[HOUSE]" placeholder="<?= GetMessage("profile_home"); ?>" value="">
		</div>
		<div class="bd-input">
			<input type="text" name="ADDRESS[APARTMENT]" placeholder="<?= GetMessage("profile_appartment"); ?>" value="">
		</div>
		<div class="profile-footer">
			<button type="button" class="save-profile save-address"><?= GetMessage("profile_save"); ?></button>
		</div>
	</form>
</div>