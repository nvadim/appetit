<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); global $USER; ?>
                <div id="basket" class="bd-popup">
                  <div class="information-col pull-xs-left">
                    <div style="display:none;" class="product-info-cont">
                      <div class="constructor-view">
                        <div class="row">
                          <div class="col-xs-4">
                            <div class="product-image"><img>
                              <div class="close-view">
                                <svg viewBox="0 0 129 129"><path d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"/></svg>
                              </div>
	                            <div class="apply-view">
		                            <svg><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"></path></svg>
	                            </div>
                            </div>
                          </div>
                          <div class="col-xs-8 nopad">
                            <div class="name"></div>
                          </div>
                        </div>
                        <div class="constructor-scroll-content scrollbar-macosx">
                          <div class="row description">
                            <div class="col-xs-12">
                            </div>
                          </div>
                          <div class="row constructor-content">
                            <div class="col-xs-12">
                              <div class="property-label"> <?=GetMessage("ORDER_WOK_BASE");?></div>
                              <div class="property-value base_value_"></div>
                              <div class="property-label"> <?=GetMessage("ORDER_WOK_SOUSE");?></div>
                              <div class="property-value souse_value_"></div>
                              <div class="property-label"> <?=GetMessage("ORDER_WOK_INGREDIENTS");?></div>
                              <div class="ingredients_list_">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div style="display:none;" class="product-scroll-content">
                          <div class="product-description"></div>
                          <div class="product-options"></div>
                        </div>
                      </div>
                      <div class="likes">
                        <div class="like-content">
                          <div class="like-icon"></div><span>5</span>
                        </div>
                      </div>
                    </div>
                    <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_GIFT_ENABLED','',SITE_ID) == 'Y'): ?>
                    <div class="basket-gift-container">
                      <div class="progress-container in-progress">
                        <div class="progress-bar"></div>
                        <div class="progress-bar-content">
                          <div><?=GetMessage("IF_U_SPEND");?></div>
                          <div class="sum-to-gift"><span>0</span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                          <div><?=GetMessage("U_GET_GIFT");?></div>
                        </div>
                      </div>
                      <div class="progress-container progress-completed">
                        <div style="width: 100%;" class="progress-bar complete use"></div>
                        <div class="progress-bar-content"><a href="<?=SITE_DIR?>gifts/" class="btn-get-gift"><?=GetMessage("GIFT_GET");?></a></div>
                      </div>
                      <div class="progress-container progress-get-another">
                        <div style="width: 100%;" class="progress-bar complete reuse"></div>
                        <div class="progress-bar-content"><a href="<?=SITE_DIR?>gifts/" class="btn-get-gift another"><?=GetMessage("GIFT_OTHER");?></a></div>

                      </div>
                    </div>
                    <?php endif; ?>
                    <div class="recommendation-container no-recommendation">
                      <div class="text-content">
                        <div class="info-col-content">
	                       <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/offer_1.php", "EDIT_TEMPLATE" => ""),false);?>
                        </div>
                        <div class="info-col-content">
	                        <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/offer_2.php", "EDIT_TEMPLATE" => ""),false);?>
                        </div>
                        <div class="info-col-content">
	                        <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/offer_3.php", "EDIT_TEMPLATE" => ""),false);?>
                        </div>
                      </div>
                      <footer>
                        <div class="phone"><?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID) ?></div>
                        <div class="work-time"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/work_time_basket.php", "EDIT_TEMPLATE" => ""),false);?></div>
                      </footer>
                    </div>
                    <div class="recommendation-container recommendation-list">
                      <div class="rc-list"></div>
                      <ul class="rc-nav"></ul>
                    </div>
                    <div class="recommendation-container static-banner">
                      <div class="text-content"></div>
                    </div>
                  </div>
                  <div class="basket-items-col pull-xs-right">
                    <div class="spinner"></div>
                    <div class="basket-title"><?=GetMessage("BASKET_TITLE");?></div>
                    <div class="products-list bd-scrollbar scrollbar-macosx"></div>
                    <div class="basket-actions">
                      <div class="row">
                        <div class="col-xs-4">
                          <div class="bd-input">
                            <label class="text-xl-center"><?=GetMessage("INPUT_PROMO");?></label>
                            <input type="text" class="basket-promo-code text-xs-left">
                          </div>
                          <a href="#" class="apply-code-btn">
                            <svg viewBox="0 0 25 25"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"></path></svg>
                          </a>
                        </div>
                        <div class="col-xs-4 order-total-container">
                          <div class="order-total">
                            <div class="summary-label"><?=GetMessage("ORDER_SUMM");?>:</div>
                            <div class="order-sum font-fix"><span></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                            <div class="order-discount"><?=GetMessage("BASKET_SALE");?> <span></span>%</div>
                          </div>
                        </div>
                        <div class="col-xs-4 bonuses-info text-xs-left">
                        <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID)=='Y'): ?>
                          <?php if($USER->IsAuthorized()): ?>
                              <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_NOT_APPEND_BONUSES_PROMO','',SITE_ID)=='Y'): ?>
                                <div class="bonuses-with-promo-disabled"><?=GetMessage("ORDER_NO_BONUSES");?></div>
                              <?php endif; ?>
                              <div class="default-text">
                              <?=GetMessage("ORDER_BONUS_1");?><br /> <span></span> <span class="currency"><?=CURRENCY_FONT; ?></span> <?=GetMessage("ORDER_BONUS_2");?>
                              </div>
                          <?php else: ?>
                            <?=GetMessage("ORDER_BONUS_3");?>
                           <?php endif; ?>
                         <?php else: ?>
                          <?=GetMessage("ORDER_BONUS_DISABLED");?>
                          <?php endif; ?>
                        </div>
                      </div>
                      <a href="<?=SITE_DIR?>checkout/" class="basket-checkout-btn"><?=GetMessage("BASKET_BUTTON");?></a>
                      <div class="progress-container in-progress min-order-progress" data-min-order="<?php echo \COption::GetOptionString('bd.deliverypizza','BD_BASKET_MIN_ORDER','',SITE_ID) ?>">
                        <div class="progress-bar"></div>
                        <div class="progress-bar-content">
                          <div class="min-order-sum"><span><?=GetMessage('ORDER_MIN_ORDER');?> </span><span><?php echo \COption::GetOptionString('bd.deliverypizza','BD_BASKET_MIN_ORDER','',SITE_ID) ?></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>