<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
<div class="profile-content bonuses font-fix">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="bonuses-progress">
                  <div class="bonuses-progress-item got"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                  <div class="bonuses-progress-item <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ): ?>got<?php endif; ?>"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                  <div class="bonuses-progress-item <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ): ?>got<?php endif; ?>"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 nopadl progress-information">
                <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ){ ?>
                <div class="progress-stat"><strong><?= GetMessage("bonuses_top_discount"); ?></strong></div>
                <?php }elseif(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ){ ?>
                  <div class="progress-stat"><?= GetMessage("bonuses_you_order"); ?> <span class="orders-totals"><?php echo number_format($arResult['ORDERS_SUM'],0,'.',' '); ?></span> <span class="currency"><?=CURRENCY_FONT; ?></span><br> <?= GetMessage("bonuses_left"); ?> <span class="span orders-totals-need"><?php echo number_format($arResult['NEED_SUM'],0,'.',' '); ?> </span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_for_next_lever_discount"); ?></div>
                <?php }elseif(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_ORDERS_SUM', '', SITE_ID) > $arResult['ORDERS_SUM'] ){ ?>
                  <div class="progress-stat"><?= GetMessage("bonuses_you_order"); ?> <span class="orders-totals"><?php echo number_format($arResult['ORDERS_SUM'],0,'.',' '); ?></span> <span class="currency"><?=CURRENCY_FONT; ?></span><br> <?= GetMessage("bonuses_left"); ?> <span class="span orders-totals-need"><?php echo number_format($arResult['NEED_SUM'],0,'.',' '); ?> </span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_for_next_lever_discount"); ?></div>
                <?php } ?>

              </div>
            </div>
            <div class="row promo-items">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 promo-block">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="promo-image"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/bonus-image-1.png" alt=""></div>
                  </div>
                  <div class="col-xs-8">
                    <div class="title"><?= GetMessage("bonuses_get_yummi"); ?> <?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_CASHBACK', '', SITE_ID); ?>% <?= GetMessage("bonuses_from_summ"); ?></div>
                    <div class="description"><?= GetMessage("bonuses_promo_text_1"); ?></div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 promo-block">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="promo-image"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/bonus-image-2.png" alt=""></div>
                  </div>
                  <div class="col-xs-8">
                    <div class="title"><?= GetMessage("bonuses__promo_title_2"); ?></div>
                    <div class="description"><?= GetMessage("bonuses_get_summ_for"); ?> <?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_ORDERS_SUM', '', SITE_ID); ?> <span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_and_get"); ?> <?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_CASHBACK', '', SITE_ID); ?>% <?= GetMessage("bonuses_from_summ_next_order"); ?></div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 promo-block">
                <div class="row">
                  <div class="col-xs-4">
                    <div class="promo-image"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/bonus-image-3.png" alt=""></div>
                  </div>
                  <div class="col-xs-8">
                    <div class="title"><?= GetMessage("bonuses_u_can_spend_what_u_want"); ?></div>
                    <div class="description"><?= GetMessage("bonuses_use_your_bonuses_bitch"); ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<?php else: ?>
  <div class="content-page page-404 font-fix error_text page-403">
    <div class="status-title"><?=GetMessage("sub_module_disabled");?></div>
  </div>
<?php endif; ?>