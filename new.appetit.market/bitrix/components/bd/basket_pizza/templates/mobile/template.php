<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); global $USER; ?>

<div class="basket basket-p" style="display: none;">
  <div class="basket-view main-view">
    <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_GIFT_ENABLED','',SITE_ID) == 'Y'): ?>
    <div class="progress-container gift-progress">
      <div style="width: 0%;" class="progress-bar"></div>
      <div class="progress-bar-content font-fix">
        <div class="sum-to-gift"><?=GetMessage("IF_U_SPEND");?> <span>0</span><span class="currency"><?=CURRENCY_FONT;?></span><br> <?=GetMessage("U_GET_GIFT");?></div>
      </div>
    </div>
    <div class="gift-progress-complete" style="display: none;">
      <a href="<?=SITE_DIR?>gifts/"><span><?=GetMessage("GIFT_GET");?></span></a>
    </div>
    <?php endif; ?>
    <div class="products-list">

    </div>
    <div class="grey-bg-basket">
      <div class="promo-block">
        <input type="text" class="basket-promo-code" placeholder="<?=GetMessage("INPUT_PROMO");?>">
        <a href="#" class="apply-code-btn">
          <svg><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"></path></svg>
        </a>
      </div>
      <div class="ot-cont basket-actions">
      <div class="col-xs-6 order-total-container">
        <div class="order-total">

          <div class="order-sum font-fix"><span></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
          <div class="order-discount"><?=GetMessage("BASKET_SALE");?> <span></span>%</div>
        </div>
      </div>
      <div class="col-xs-6 bonuses-info text-xs-left">
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
    </div>
    <div class="checkout-cont">
      <button type="button" onclick="window.location.href='<?=SITE_DIR?>checkout/'" class="checkout-btn"><?=GetMessage("BASKET_BUTTON");?></button>
    </div>
	  <div class="progress-container in-progress min-order-progress" data-min-order="<?php echo \COption::GetOptionString('bd.deliverypizza','BD_BASKET_MIN_ORDER','',SITE_ID) ?>">
		  <div class="progress-bar"></div>
		  <div class="progress-bar-content">
			  <div class="min-order-sum"><span><?=GetMessage('ORDER_MIN_ORDER');?> </span><span><?php echo \COption::GetOptionString('bd.deliverypizza','BD_BASKET_MIN_ORDER','',SITE_ID) ?></span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
		  </div>
	  </div>
  </div>
  <div style="display: none;" class="basket-view change-view product-info-cont">
    <div class="status-bar detail-shadow">
      <a href="#" onclick="backToBasket()" class="back"></a>
      <div class="title"></div>
    </div>
    <div class="product-detail-cont constructor-view ">
      <div class="product product-detail">
        <div class="name"></div>
        <div class="product-image"><img></div>
        <div class="likes">
          <div class="like-content">
            <div class="like-icon"></div><span></span>
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
        <div itemprop="description" class="product-description"></div>
        <div class="product-footer">
          <!--<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="product-prices font-fix"><span class="old-price"><span class="line-through">150</span><span class="currency">R</span></span><span itemprop="price" class="current-price">120<span class="currency">R</span><span itemprop="priceCurrency" class="text-hide">RUB</span></span><span class="weight">220 ã</span></div>-->
          <div class="product-options">

            <div class="clearfix"></div>
          </div>
          <div class="product-actions">
            <button disabled class="apply-view native"><?=GetMessage("SAVE_EDITED");?></button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>