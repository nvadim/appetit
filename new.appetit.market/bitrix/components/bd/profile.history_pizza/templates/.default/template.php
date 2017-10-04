<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bd\Deliverypizza\Models;
?>

<div class="profile-content order-history">
            <div class="row">
              <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-xs-12">
                <table class="order-history-table">
                  <thead>
                    <tr>
                      <td><?= GetMessage("history_id"); ?></td>
                      <td><?= GetMessage("history_date"); ?></td>
                      <td><?= GetMessage("history_order"); ?></td>
                      <td><?= GetMessage("history_summ"); ?></td>
                      <td><?= GetMessage("history_status"); ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(count($arResult['ORDERS'])>0): ?>
                  <?php foreach($arResult['ORDERS'] as $order): ?>
                    <tr class="complete">
                      <td>#<?php echo $order['ID']; ?></td>
                      <td class="order-date"><?php echo date('d.m.Y',$order['ORDER_DATE']); ?></td>
                      <td>
                        <?php
                          $basket = unserialize($order['BASKET_CONTENT']);
                          $m = new Bd\Deliverypizza\Models\Basket();
                          $products = $m->getBasketContentForHistory($basket);
                        ?>
                        <a href="#" data-id="<?php echo $order['ID']; ?>" class="order-detail-btn"><?php echo formatLabel(count($basket),array(GetMessage("quantity"),GetMessage("quantitys"),GetMessage("quantitys_2"))); ?></a></td>
                      <td><?php echo number_format($order['ORDER_SUM'],0 ,'.',' '); ?> <span class="currency font-fix"><?=CURRENCY_FONT; ?></span></td>
                      <td class="order-status" style="color: <?php echo Models\Order::$statuses[$order['STATUS']]['color']; ?>;"><?php echo Models\Order::$statuses[$order['STATUS']]['name']; ?></td>
                      <td>
                        <?php if($order['STATUS']==4): ?>
                          <a href="/payment-init.php?order=<?php echo $order['ID']; ?>" class="repay-btn"><?= GetMessage("history_repay"); ?></a>
                        <?php else: ?>
                        <a href="#" class="reorder-btn" data-id="<?php echo $order['ID']; ?>"><?= GetMessage("history_repeat"); ?></a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <tr class="history" data-id="<?php echo $order['ID']; ?>">
                      <td colspan="3">
                        <table class="product-list">
                          <?php foreach($products['products'] as $prod): ?>
                              <?php if(!empty($prod['NAME'])): ?>
                                <tr>
                                  <td class="name">
                                      <div><a data-modal="product-detail" href="#" <?php if(!in_array($prod['ID'],$products['ids'])): ?>class="without_info" onclick="return false;"<?php else: ?> onclick="getProductDetail(<?php echo $prod['ID'] ?>); return false;" class="md-trigger"  <?php endif; ?>><?php echo $prod['NAME'] ?></a></div>
                                      <div class="section"><?php echo $prod['SECTION']; ?></div>
                                  </td>
                                  <td class="local_sum">

                                    <?php echo number_format($prod['LOCAL_SUM'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span>

                                  </td>
                                  <td class="amount"><?php echo $prod['AMOUNT']; ?> <?= GetMessage("history_col"); ?></td>
                                </tr>
                              <?php endif; ?>
                          <?php endforeach; ?>

                        </table>
                      </td>
                      <td colspan="3" valign="top">
                        <table class="product-list additional-info">
                          <?php if(!empty($order['DELIVERY_PRICE'])): ?>
                          <tr>
                            <td class="name">
                              <span class="name_ without_info"><?= GetMessage("history_delivery"); ?></span>
                            </td>
                            <td class="local_sum">
                              <?php echo number_format($order['DELIVERY_PRICE'],0 ,'.',' '); ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span>
                            </td>
                            <td class="amount"></td>
                          </tr>
                          <?php endif; ?>

                          <?php if(!empty($order['DISCOUNT_BONUSES'])): ?>
                          <tr>
                            <td class="name">
                              <span class="name_ without_info"><?= GetMessage("history_used_bonuses"); ?></span>
                            </td>
                            <td class="local_sum">
                              <?php echo $order['DISCOUNT_BONUSES']; ?><span class="currency font-fix"><?=CURRENCY_FONT; ?></span>
                            </td>
                            <td class="amount"></td>
                          </tr>
                          <?php endif; ?>
                          <?php if(!empty($order['DISCOUNT']) && empty($order['DISCOUNT_PICKUP'])): ?>
                          <tr>
                            <td class="name">
                              <span class="name_ without_info"><?= GetMessage("history_discount_promo"); ?></span>
                            </td>
                            <td class="local_sum">
                              <?php echo $order['DISCOUNT']; ?>%</span>
                            </td>
                            <td class="amount"></td>
                          </tr>
                          <?php endif; ?>

                          <?php if(!empty($order['DISCOUNT_PICKUP'])): ?>
                            <tr>
                              <td class="name">
                                <span class="name_ without_info"><?= GetMessage("history_discount_pickup"); ?></span>
                              </td>
                              <td class="local_sum">
                                <?php echo $order['DISCOUNT_PICKUP']; ?>%</span>
                              </td>
                              <td class="amount"></td>
                            </tr>
                          <?php endif; ?>
                        </table>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="6" align="center"><?= GetMessage("history_dont_have"); ?></td>
                  </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

