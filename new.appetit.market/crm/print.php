<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/orders.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/data.php';
use Bd\Deliverypizza;
CModule::IncludeModule('iblock');
$order = Deliverypizza\Entity\OrderTable::getList(array('filter'=>array('=ID'=>$_GET['id'])))->fetch();
$order['STATUS_NAME'] = Deliverypizza\Models\Order::$statuses[$order['STATUS']]['name'];
$basket_m = new Deliverypizza\Models\Basket();
$basket_res = unserialize($order['BASKET_CONTENT']);
$order['BASKET_CONTENT'] = $basket_m->getBasketContent($basket_res);
foreach ($order['BASKET_CONTENT']['products'] as $k=>$bi){
	if(isset($bi['IS_CONSTRUCTOR'])){
		$order['BASKET_CONTENT']['products'][$k]['SECTION'] = GetMessage("wok_box");
		$order['BASKET_CONTENT']['products'][$k]['CLASSES'] .= ' without_detail';
		if($bi['BASE_ID']){

			$base = CIBlockElement::GetByID($bi['BASE_ID'])->GetNext();

			$order['BASKET_CONTENT']['products'][$k]['BASE_NAME'] = $base['NAME'];
		}
		if($bi['SOUSE_ID']){
			$souse = CIBlockElement::GetByID($bi['SOUSE_ID'])->GetNext();
			$order['BASKET_CONTENT']['products'][$k]['SOUSE_NAME'] = $souse['NAME'];
		}
		if($bi['INGREDIENTS']){
			foreach ($bi['INGREDIENTS'] as $ing){
				$ing_ = CIBlockElement::GetByID($ing)->GetNext();
				$order['BASKET_CONTENT']['products'][$k]['INGREDIENTS_NAME'][$ing] = $ing_['NAME'];
				if($bi['ING_AMOUNT'][$ing] > 1){
					$order['BASKET_CONTENT']['products'][$k]['INGREDIENTS_NAME'][$ing] .= ' x'.$bi['ING_AMOUNT'][$ing];
				}
			}
		}
	}
}
$cleaned = preg_replace('/[^[:digit:]]/', '', $order['USER_PHONE']);
preg_match('/\d{1}(\d{3})(\d{3})(\d{2})(\d{2})/', $cleaned, $matches);

$order['USER_PHONE'] = "+".PHONE_CODE." ({$matches[1]}) {$matches[2]}-{$matches[3]}-{$matches[4]}";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title><?php echo GetMessage("print_order"); ?> #<?=$order['ID']?></title>
	<link href="<?=SITE_DIR?>crm/static/print/css/style.css" rel="stylesheet">
</head>

<body>

<div class="print-page">
	<div class="print-page__head row">
		<div class="about-order">
			<div class="about-order__num"><?php echo GetMessage("order"); ?> <span class="num">#<?=$order['ID']?></span> <span class="about-order__date">(<?=date('d.m.y, H:i:s',$order['ORDER_DATE'])?>)</span></div>
			<div class="about-order__client-name"><?=$order['USER_NAME']?> | <?=$order['USER_PHONE']?></div>
			<div class="about-order__client-info">
				<p><b><?php echo GetMessage("delivery_time"); ?></b>
				<?php if($order['DELIVERY_TIME_TYPE'] == 0): ?>
					<?php echo GetMessage("now"); ?>
				<?php else: ?>
					<?=date('d.m.Y ',$order['RELEASE_DATE']).$order['DELIVERY_TIME'];?>
				<?php endif; ?>
				</p>
				<?php if($order['DELIVERY_TYPE'] == 1): ?>
				<p><b><?php echo GetMessage("address"); ?></b> <?php echo GetMessage("street"); ?> <?=$order['STREET']?> <?=$order['HOUSE']?><?php echo GetMessage("appartaments"); ?> <?=$order['APARTMENT']?></p>
				<?php else: ?>
				<p><b><?php echo GetMessage("take_away"); ?></b>
					<?php
					$name = \CIBlockElement::GetByID($order['DELIVERY_PICKUP_ID'])->GetNext();

					echo $name['NAME'];
					?></p>
				<?php endif; ?>
				<p><b><?php echo GetMessage("pay_order"); ?></b> <?php foreach($payments as $p){if($p['ID']==$order['PAYMENT_TYPE']) echo $p['NAME'];} ?>
					<?php if(!empty($order['ONLINE_PAY_SIGNATURE'])): ?>
						<?php if($order['ONLINE_PAY_STATUS'] == 1): ?>
							<span class="paid"><?php echo GetMessage("payed"); ?></span>
						<?php else: ?>
							<span class="no-paid"><?php echo GetMessage("not_payed"); ?></span>
						<?php endif; ?>
					<?php endif; ?>
					</p>
				<?php if($order['ODD_MONEY'] > 0): ?>
				<p><b><?php echo GetMessage("need_change"); ?></b> <?=$order['ODD_MONEY']?> </p>
				<?php endif; ?>
				<?php if(!empty($order['COMMENT'])): ?>
				<p><b><?php echo GetMessage("comment"); ?></b> <?=$order['COMMENT']?></p>
				<?php endif; ?>
			</div>
		</div><!-- .about-order -->
		<div class="about-company">
			<?php $logo = \CFile::GetFileArray(\COption::GetOptionInt('bd.deliverypizza','BD_SITE_LOGO','',SITE_ID)); ?>
			<div class="about-company__logo"><img src="<?php echo $logo['SRC'] ?>" alt=""></div>

			<div class="about-company__address"><?=\COption::GetOptionString('bd.deliverypizza','BD_CRM_PRINT_ADDRESS','',SITE_ID)?></div>
			<div class="about-company__phone"><?=\COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID) ?></div>
		</div><!-- .about-company -->
	</div><!-- .print-page__head -->
	<div class="print-page__content">
		<div class="print-page__content-head">
			<div class="print-page__content-head-name"><?php echo GetMessage("name"); ?></div>
			<div class="print-page__content-head-price"><?php echo GetMessage("price"); ?></div>
			<div class="print-page__content-head-quantity"><?php echo GetMessage("quantity"); ?></div>
			<div class="print-page__content-head-sum"><?php echo GetMessage("sum"); ?></div>
		</div>
		<div class="print-page__content-body">
			<?php foreach($order['BASKET_CONTENT']['products'] as $item):?>
			<div class="print-page__content-body-row">
				<div class="print-page__content-body-name">
					<p><?=$item['NAME'];?></p>
					<?php if(isset($item['IS_CONSTRUCTOR'])): ?>
						<div class="additionally">
							<div class="additionally__title"><?php echo GetMessage("base"); ?></div>
							<p><?=$item['BASE_NAME']?></p>
							<div class="additionally__title"><?php echo GetMessage("sous"); ?></div>
							<p><?=$item['SOUSE_NAME']?></p>
						</div>
						<div class="additionally">
							<div class="additionally__title"><?php echo GetMessage("ingredients"); ?></div>
							<?php foreach($item['INGREDIENTS_NAME'] as $ing_name): ?>
							<p><?=$ing_name?></p>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<?php if($item['OPTIONS'][1] !== null):?>
							<div class="additionally">
								<div class="additionally__title"><?=$products[$item['SECTION_ID']][$item['ID']]['option_1'][$item['OPTIONS'][1]]['PROP'];?></div>
								<p><?=$products[$item['SECTION_ID']][$item['ID']]['option_1'][$item['OPTIONS'][1]]['VALUE'];?></p>
							</div>
						<?php endif; ?>
						<?php if($item['OPTIONS'][2] !== null):?>
						<div class="additionally">
							<div class="additionally__title"><?=$products[$item['SECTION_ID']][$item['ID']]['option_2'][$item['OPTIONS'][2]]['PROP'];?></div>
							<p><?=$products[$item['SECTION_ID']][$item['ID']]['option_2'][$item['OPTIONS'][2]]['VALUE'];?></p>
						</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="print-page__content-body-price"><?=$item['PRICE']?>  <span class="currency"><?=CURRENCY_FONT?></span></div>
				<div class="print-page__content-body-quantity"><?=$item['AMOUNT']?></div>
				<div class="print-page__content-body-sum"><?=$item['LOCAL_SUM']?> <span class="currency"><?=CURRENCY_FONT?></span></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="print-page__footer row">
		<div class="thanks-order">
			<div class="thanks-order__title"><?php echo GetMessage("thanks_for_order"); ?></div>
			<div class="thanks-order__attention"><?php echo GetMessage("attention"); ?></div>
			<p><?=nl2br(\COption::GetOptionString('bd.deliverypizza','BD_CF_CRM_PRINT_BOTTOM_TEXT','',SITE_ID)); ?></p>
		</div><!-- thanks-order -->
		<div class="total-box">
			<p><?php echo GetMessage("delivery_price"); ?> <b><?=$order['DELIVERY_PRICE']?> <span class="currency"><?=CURRENCY_FONT?></span></b></p>
			<?php $disc = 0; ?>
			<?php if(!empty($order['PROMO_CODE'])): ?>
				<?php $disc = $order['DISCOUNT']; ?>
			<p><?php echo GetMessage("discount_promo"); ?> <b><?=$order['DISCOUNT']?>% (<?=$order['PROMO_CODE'];?>)</b></p>
			<?php endif; ?>
			<?php if(!empty($order['DISCOUNT_PICKUP'])): ?>
				<?php $disc = $order['DISCOUNT_PICKUP']; ?>
			<p><?php echo GetMessage("discount_take_away"); ?> <b><?=$order['DISCOUNT_PICKUP'];?>%</b></p>
			<?php endif; ?>
			<?php if($order['DISCOUNT_BONUSES'] > 0): ?>
			<p><?php echo GetMessage("pay_bonuses"); ?> <b><?=$order['DISCOUNT_BONUSES']?> <span class="currency"><?=CURRENCY_FONT?></span></b></p>
			<?php endif; ?>
			<p><?php echo GetMessage("order_sum"); ?> <b><?=$order['ORDER_SUM']?> <span class="currency"><?=CURRENCY_FONT?></span></b></p>
			<div class="in-total">
				<span class="text"><?php echo GetMessage("sum_all"); ?></span>
				<?php
					if($disc > 0){
						$order['ORDER_SUM']  = intval($order['ORDER_SUM'] - ($order['ORDER_SUM'] * $disc/100));
					}
				?>
				<?=$order['ORDER_SUM']+$order['DELIVERY_SUM']-$order['DISCOUNT_BONUSES']?> <span class="currency"><?=CURRENCY_FONT?></span>
			</div>
		</div><!-- total-box -->
	</div>


</div><!-- .print-page -->

</body>
</html>