<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bd\Deliverypizza\Models;
?>


          <div class="profile-view history-view">
	        <?php if(count($arResult['ORDERS'])>0): ?>
	        <?php foreach($arResult['ORDERS'] as $order): ?>
	         <?php
               $basket = unserialize($order['BASKET_CONTENT']);
               $m = new Bd\Deliverypizza\Models\Basket();
             ?>
            <div class="config-item"><a href="#" onclick="getProfileView('order<?php echo $order['ID']; ?>')" >#<?php echo $order['ID']; ?> – <?php echo formatLabel(count($basket),array(GetMessage("quantity"),GetMessage("quantitys"),GetMessage("quantitys_2"))); ?> <span class="date">(<?php echo date('d.m.Y',$order['ORDER_DATE']); ?>)</span> <span class="order-status" style="background-color: <?php echo Models\Order::$statuses[$order['STATUS']]['color']; ?>;"><?php echo Models\Order::$statuses[$order['STATUS']]['name']; ?></span></a></div>
               <?php endforeach; ?>
             <?php else: ?>
			    <div class="config-item"><?= GetMessage("history_dont_have"); ?></div>
              <?php endif; ?>
          </div>
          
          <?php foreach($arResult['ORDERS'] as $order): ?>
          	 <?php
               $basket = unserialize($order['BASKET_CONTENT']);
               $m = new Bd\Deliverypizza\Models\Basket();
               $products = $m->getBasketContentForHistory($basket);
             ?>
              <div class="profile-view h-order-view order<?=$order['ID'];?>-view" style="display: none;" data-target-title="<?= GetMessage("history_order"); ?> #<?php echo $order['ID']; ?>">
                <div class="order-status" style="background-color: <?php echo Models\Order::$statuses[$order['STATUS']]['color']; ?>;"><?php echo Models\Order::$statuses[$order['STATUS']]['name']; ?></div>
                <div class="basket">
                  <div class="products-list">
                    <?php foreach($products['products'] as $prod): ?>
                     <?php if(!empty($prod['NAME'])):?>
                    <div class="basket-item row">
                        <div class="product-image"><img src="<?=$prod['IMAGE'];?>" alt=""></div>
                      <div class="name-cont">
                        <div class="name"><?php echo $prod['NAME'] ?></div>
                        <div class="section"><?php echo $prod['SECTION']; ?></div>
                      </div>
                      <div class="price-block"><span class="product-sum font-fix"><?php echo number_format($prod['LOCAL_SUM'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span></span></div>
                    </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                    <?php if(!empty($order['DELIVERY_PRICE']) || !empty($order['DISCOUNT_BONUSES']) || !empty($order['DISCOUNT']) || !empty($order['DISCOUNT_PICKUP']) || !empty($order['DISCOUNT_PICKUP'])): ?>
                  <div class="promo-block">
                      <div class="order-config">
                    <?php if(!empty($order['DELIVERY_PRICE'])): ?>
                       <span class="config-label"><?= GetMessage("history_delivery"); ?>: </span> <span class="config-value"><?php echo number_format($order['DELIVERY_PRICE'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span></span>
                     <?php endif; ?>
                      </div>
                      <div class="order-config">
                    <?php if(!empty($order['DISCOUNT_BONUSES'])): ?>
                          <span class="config-label"> <?= GetMessage("history_used_bonuses"); ?>:</span> <span class="config-value"> <?php echo $order['DISCOUNT_BONUSES']; ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span></span>
                    <?php endif; ?>
                      </div>
                      <div class="order-config">
                    <?php if(!empty($order['DISCOUNT']) && empty($order['DISCOUNT_PICKUP'])): ?>
                        <span class="config-label"> <?= GetMessage("history_discount_promo"); ?>:</span> <span class="config-value"> <?php echo $order['DISCOUNT']; ?>%</span>
                    <?php endif; ?>
                      </div>
                      <div class="order-config">
                    <?php if(!empty($order['DISCOUNT_PICKUP'])): ?>
                        <span class="config-label"><?= GetMessage("history_discount_pickup"); ?>:</span> <span class="config-value"> <?php echo $order['DISCOUNT_PICKUP']; ?>%</span>
                    <?php endif; ?>
                      </div>
                  </div>
                    <?php endif; ?>
                  <div class="checkout-cont">
                    <button type="button" class="checkout-btn" data-id="<?php echo $order['ID']; ?>"><?= GetMessage("history_repeat"); ?></button>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>