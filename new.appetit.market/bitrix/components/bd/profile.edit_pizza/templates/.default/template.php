<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
          <div class="profile-content">
            <form action="" method="post">
              <input type="hidden" name="USER[ID]"  value="<?php echo $arResult['USER']['ID']; ?>">
              <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                  <div class="bd-input <?php if(!empty($arResult['USER']['NAME'])): ?>filled<?php endif; ?>">
                    <label class="text-xs-left"><?= GetMessage("profile_name"); ?></label>
                    <input type="text" class="text-xs-left" name="USER[NAME]"  value="<?php echo $arResult['USER']['NAME']; ?>">
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6 radios gender_cont">
                  <input type="hidden" name="USER[GENDER]"  value="<?php echo $arResult['USER']['GENDER']; ?>"/>
                  <label>
                    <input type="radio" <?php if($arResult['USER']['GENDER']=='male'): ?> checked <?php endif; ?> name="time_type" id="male">
                    <label for="male"><span></span></label><span><?= GetMessage("profile_man"); ?></span>
                  </label>
                  <label>
                    <input <?php if($arResult['USER']['GENDER']=='female'): ?> checked <?php endif; ?> type="radio" name="time_type" id="female">
                    <label for="female"><span></span></label><span><?= GetMessage("profile_women"); ?></span>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                  <div class="bd-input <?php if(!empty($arResult['USER']['BIRTHDAY'])): ?>filled<?php endif; ?>">
                    <label class="text-xs-left"><?= GetMessage("profile_birthday"); ?></label>
                    <input type="text" maxlength="10" class="text-xs-left" name="USER[BIRTHDAY]" value="<?php echo $arResult['USER']['BIRTHDAY']; ?>">
                  </div>
                </div>
              </div>

              <?php if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'sms'): ?>
                <div class="row">
                  <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                    <div class="bd-input <?php if(!empty($arResult['USER']['EMAIL'])): ?>filled<?php endif; ?>">
                      <label class="text-xs-left"><?= GetMessage("profile_email"); ?></label>
                      <input type="text" class="text-xs-left" name="USER[EMAIL]" value="<?php echo $arResult['USER']['EMAIL']; ?>">
                    </div>
                  </div>
                </div>
                <div class="row profile-phone">
                  <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                    <div class="current-phone"><?php echo $arResult['USER']['PHONE']; ?></div>
                    <div class="change-phone"><?= GetMessage("profile_text_change_phone"); ?> <?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE', '', SITE_ID) ?></div>
                  </div>
                </div>
              <?php endif; ?>

              <?php  if(COption::GetOptionString('bd.deliverypizza', 'BD_CF_AUTH_TYPE', '', SITE_ID) == 'email'): ?>
                <div class="row">
                  <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                    <div class="bd-input <?php if(!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!==PHONE_CODE): ?>filled<?php endif; ?>">
                      <label class="text-xs-left"><?= GetMessage("profile_phone"); ?></label>
                      <input type="text" class="text-xs-left" name="USER[PHONE]" value="<?php echo (!empty($arResult['USER']['PHONE']) && $arResult['USER']['PHONE']!==PHONE_CODE)?$arResult['USER']['PHONE']:''; ?>">
                    </div>
                  </div>
                </div>
                <div class="row profile-phone">
                  <div class="col-xl-3 col-lg-3 col-sm-6 col-md-4 col-xs-6">
                    <div class="current-phone"><?php echo $arResult['USER']['EMAIL']; ?></div>
                    <div class="change-phone"><?= GetMessage("profile_text_change_email"); ?> <?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE', '', SITE_ID) ?></div>
                  </div>
                </div>
              <?php endif; ?>

              <div class="row notify-config">
                <div class="col-xs-12">
                  <input type="hidden" name="USER[NOTIFY_SMS]" value="<?php echo $arResult['USER']['NOTIFY_SMS']; ?>"/>
                  <input type="hidden" name="USER[NOTIFY_EMAIL]" value="<?php echo $arResult['USER']['NOTIFY_EMAIL']; ?>"/>
                  <label>
                    <input type="checkbox" <?php if($arResult['USER']['NOTIFY_SMS']==1): ?> checked <?php endif; ?> data-target="NOTIFY_SMS"><span><?= GetMessage("profile_get_sms"); ?></span>
                  </label>
                  <label>
                    <input <?php if($arResult['USER']['NOTIFY_EMAIL']==1): ?> checked <?php endif; ?> type="checkbox" data-target="NOTIFY_EMAIL"><span><?= GetMessage("profile_get_email"); ?></span>
                  </label>
                </div>
              </div>
              <div class="row address-list-container">
                <div class="address-list">
                  <?php foreach($arResult['USER']['ADDRESSES'] as $address): ?>
                  <div class="address-item">
                    <input type="hidden" class="to_delete" name="ADDRESS[<?php echo $address['ID']; ?>][TO_DELETE]" value="0"/>
                    <div class="row sub-row bordered-row">
                      <div class="col-xl-6 col-lg-10 col-sm-12 col-md-12 col-xs-12 bordered"></div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <div class="bd-input <?php if(!empty($address['NAME'])): ?>filled <?php endif; ?>">
                          <label class="text-xs-left"><?= GetMessage("profile_address_name"); ?></label>
                          <input type="text" name="ADDRESS[<?php echo $address['ID']; ?>][NAME]" value="<?php echo $address['NAME']; ?>" class="text-xs-left">
                        </div>
                      </div>
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6"><a href="#" class="remove-address"><span><?= GetMessage("profile_delite_adress"); ?></span></a></div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <select name="ADDRESS[<?php echo $address['ID']; ?>][DISTRICT_ID]" class="cs-select cs-skin-slide">
                          <option value="null"><?= GetMessage("profile_destrict"); ?></option>
                          <?php foreach($arResult["DESTRICT"] as $d): ?>
                            <option <?php if($address['DISTRICT_ID']==$d['ID']): ?>selected<?php endif; ?> value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <div class="bd-input <?php if(!empty($address['STREET'])): ?>filled <?php endif; ?>">
                          <label class="text-xs-left"><?= GetMessage("profile_street"); ?></label>
                          <input type="text" name="ADDRESS[<?php echo $address['ID']; ?>][STREET]" value="<?php echo $address['STREET']; ?>" class="text-xs-left">
                        </div>
                      </div>
                      <div class="col-xl-1 col-lg-2 col-sm-2 col-md-2 col-xs-2 nopadl">
                        <div class="bd-input <?php if(!empty($address['HOUSE'])): ?>filled <?php endif; ?>">
                          <label class="text-xs-left"><?= GetMessage("profile_home"); ?></label>
                          <input type="text" class="text-xs-left" name="ADDRESS[<?php echo $address['ID']; ?>][HOUSE]" value="<?php echo $address['HOUSE']; ?>">
                        </div>
                      </div>
                      <div class="col-xl-1 col-lg-2 col-sm-2 col-md-2 col-xs-2 nopadl">
                        <div class="bd-input <?php if(!empty($address['APARTMENT'])): ?>filled <?php endif; ?>">
                          <label class="text-xs-left"><?= GetMessage("profile_appartment"); ?></label>
                          <input type="text" class="text-xs-left" name="ADDRESS[<?php echo $address['ID']; ?>][APARTMENT]" value="<?php echo $address['APARTMENT']; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
                <div class="address-template_" style="display: none;">
                  <div class="address-item">
                    <input type="hidden" class="to_delete" name="NEW_ADDRESS[TO_DELETE][]" value="0"/>
                    <div class="row sub-row bordered-row">
                      <div class="col-xl-6 col-lg-10 col-sm-12 col-md-12 col-xs-12 bordered"></div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <div class="bd-input">
                          <label class="text-xs-left"><?= GetMessage("profile_address_name"); ?></label>
                          <input type="text" class="text-xs-left" name="NEW_ADDRESS[NAME][]">
                        </div>
                      </div>
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6"><a href="#" class="remove-address"><span><?= GetMessage("profile_delite_adress"); ?></span></a></div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <select  name="NEW_ADDRESS[DISTRICT_ID][]" class="cs-select cs-skin-slide">
                          <option value="null"><?= GetMessage("profile_destrict"); ?></option>
                          <?php foreach($arResult["DESTRICT"] as $d): ?>
                            <option value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="row sub-row">
                      <div class="col-xl-3 col-lg-4 col-sm-6 col-md-6 col-xs-6">
                        <div class="bd-input">
                          <label class="text-xs-left"><?= GetMessage("profile_street"); ?></label>
                          <input type="text" class="text-xs-left" name="NEW_ADDRESS[STREET][]">
                        </div>
                      </div>
                      <div class="col-xl-1 col-lg-2 col-sm-2 col-md-2 col-xs-2 nopadl">
                        <div class="bd-input">
                          <label class="text-xs-left"><?= GetMessage("profile_home"); ?></label>
                          <input type="text" class="text-xs-left" name="NEW_ADDRESS[HOUSE][]">
                        </div>
                      </div>
                      <div class="col-xl-1 col-lg-2 col-sm-2 col-md-2 col-xs-2 nopadl">
                        <div class="bd-input">
                          <label class="text-xs-left"><?= GetMessage("profile_appartment"); ?></label>
                          <input type="text" class="text-xs-left" name="NEW_ADDRESS[APARTMENT][]">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sub-row bordered-row">
                  <div class="col-xl-6 col-lg-8 col-sm-6 col-md-8 col-xs-12 bordered"></div>
                </div>
                <div class="col-xs-12"><a href="#" class="add-address"><span><?= GetMessage("profile_add_adress"); ?></span></a></div>
                <div class="clearfix"></div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <button type="submit" class="save-profile"><?= GetMessage("profile_save"); ?></button>
                </div>
              </div>
            </form>
          </div>