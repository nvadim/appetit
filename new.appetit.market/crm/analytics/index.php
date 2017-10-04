<?php

use Bd\Deliverypizza;
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/analytics.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/common.php';
global $USER;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?php echo GetMessage("analytics_crm"); ?></title>
	<?php include_once '../include/head.php'; ?>
</head>
<body>
<div class="wrapper">
	<?php require_once '../include/header.php';?>

	<div class="filter-line">
		<div class="wrap">
			<div class="row">
				<div class="date-filter date-filter--left">
					<form action="" method="get">

						<div class="date-filter  date-filter--left">
							<div class="date-filter__title"><?php echo GetMessage("period"); ?></div>
							<input onclick="BX.calendar({node:this, field:this, bHideTime: true, bTime: false});" type="text" class="default"  value="<?=(isset($_GET['date_start']))?$_GET['date_start']:''?>" placeholder="__.__.____" name="date_start">
							<div class="date-filter__delimiter">&#8211;</div>
							<input  value="<?=(isset($_GET['date_end']))?$_GET['date_end']:''?>" type="text" onclick="BX.calendar({node:this, field:this, bHideTime: true,bTime: false});" class="default" placeholder="__.__.____" name="date_end">
							<input type="submit"  class="apply-filter  <?php if(!isset($_GET['date_end']) && !isset($_GET['date_end'])): ?>disabled<?php endif; ?>" <?php if(!isset($_GET['date_end']) && !isset($_GET['date_end'])): ?>disabled="disabled"<?php endif; ?> value="<?php echo GetMessage("apply"); ?>">

							<div style="display: none;">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.calendar",
									".default",
									array(
										"SHOW_INPUT" => "Y",
										"FORM_NAME" => "form1",
										"INPUT_NAME" => "date_fld",
										"INPUT_NAME_FINISH" => "",
										"INPUT_VALUE" => "",
										"INPUT_VALUE_FINISH" => "",
										"SHOW_TIME" => "Y",
										"HIDE_TIMEBAR" => "N"
									),
									false
								);?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</header><!-- .header-->
	<main class="content">
		<div class="wrap">
			<div class="analytics-page">
				<div class="data-selected-period">
					<div class="data-selected-period__title"><?php echo GetMessage("data_period"); ?></div>
					<div class="data-selected-period__row row">
						<div class="data-selected-period__col-3">
							<div class="data-box data-box--orders">
								<div class="title"><?=count($orders);?></div>
								<p><?=plural_form(count($orders),array(GetMessage("order"),GetMessage("ordera"),GetMessage("orders")),0)?></p>
							</div>
						</div>
						<div class="data-selected-period__col-3">
							<div class="data-box data-box--average-check">
								<div class="title"><?=$sum_avg;?><span class="currency"><?=CURRENCY_FONT?></span></div>
								<p><?php echo GetMessage("check"); ?> </p>
							</div>
						</div>
						<div class="data-selected-period__col-3">
							<div class="data-box data-box--revenue">
								<div class="title"><?=$sum;?><span class="currency"><?=CURRENCY_FONT?></span></div>
								<p><?php echo GetMessage("revenue"); ?></p>
							</div>
						</div>
					</div>
				</div><!-- .data-selected-period -->
				<div class="data-details row">
					<div class="data-details__left">
						<div class="data-details__group">
							<div class="data-details__title"><?php echo GetMessage("from_source_orders"); ?></div>
							<table class="analytics-table">
								<thead>
								<tr>
									<th><?php echo GetMessage("source"); ?></th>
									<th><?php echo GetMessage("orders_2"); ?></th>
									<th><?php echo GetMessage("revenue_2"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								$local_count = 0;
								$local_sum = 0;
								foreach($sources as $key=>$source):
									$local_count+= $source['COUNT'];
									$local_sum+= $source['SUM'];
									?>
									<tr>
										<td><?=$key?></td>
										<td><?=$source['COUNT']?></td>
										<td><?=number_format($source['SUM'],0 ,'.',' ');?><span class="currency"><?=CURRENCY_FONT?></span></td>
									</tr>
								<?php endforeach; ?>
								<tr class="last">
									<td><?php echo GetMessage("all_yeah"); ?></td>
									<td><?=$local_count;?></td>
									<td><?=number_format($local_sum,0 ,'.',' ')?><span class="currency"><?=CURRENCY_FONT?></span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="data-details__group">
							<div class="data-details__title"><?php echo GetMessage("destrict"); ?></div>
							<table class="analytics-table">
								<thead>
								<tr>
									<th><?php echo GetMessage("source"); ?></th>
									<th><?php echo GetMessage("orders_2"); ?></th>
									<th><?php echo GetMessage("revenue_2"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								$local_count = 0;
								$local_sum = 0;
								foreach($districts as $key=>$district):
									if($key == "null" || $key == 0) continue;
									$local_count+= $district['COUNT'];
									$local_sum+= $district['SUM'];
									?>
									<tr>
										<td><?=($district['NAME'])?$district['NAME']:GetMessage("take_away");?></td>
										<td><?=$district['COUNT']?></td>
										<td><?=number_format($district['SUM'],0 ,'.',' ');?><span class="currency"><?=CURRENCY_FONT?></span></td>
									</tr>
								<?php endforeach; ?>

								<tr class="last">
									<td><?php echo GetMessage("all"); ?></td>
									<td><?=$local_count;?></td>
									<td><?=number_format($local_sum,0 ,'.',' ')?><span class="currency"><?=CURRENCY_FONT?></span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="data-details__group">
							<div class="data-details__title"><?php echo GetMessage("pickups"); ?></div>
							<table class="analytics-table">
								<thead>
								<tr>
									<th><?php echo GetMessage("source"); ?></th>
									<th><?php echo GetMessage("orders_2"); ?></th>
									<th><?php echo GetMessage("revenue_2"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								$local_count = 0;
								$local_sum = 0;
								foreach($pickups as $key=>$pickup):
									if($key == "null" || $key == 0) continue;
									$local_count+= $pickup['COUNT'];
									$local_sum+= $pickup['SUM'];
									?>
									<tr>
										<td><?=($pickup['NAME'])?$pickup['NAME']:GetMessage("take_away");?></td>
										<td><?=$pickup['COUNT']?></td>
										<td><?=number_format($pickup['SUM'],0 ,'.',' ');?><span class="currency"><?=CURRENCY_FONT?></span></td>
									</tr>
								<?php endforeach; ?>

								<tr class="last">
									<td><?php echo GetMessage("all"); ?></td>
									<td><?=$local_count;?></td>
									<td><?=number_format($local_sum,0 ,'.',' ')?><span class="currency"><?=CURRENCY_FONT?></span></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="data-details__right">
						<div class="data-details__group">
							<div class="data-details__title"><?php echo GetMessage("popular_item"); ?></div>
							<table class="analytics-table">
								<thead>
								<tr>
									<th><?php echo GetMessage("name"); ?></th>
									<th><?php echo GetMessage("orders_2"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php $local_count = 0;
								foreach($product_result as $key=>$product):
									if($key==10) break;
									if(empty($product['NAME'])) continue;
								$local_count += $product['ORDERS'];
								?>
								<tr>
									<td><?=$product['NAME'];?></td>
									<td><?=$product['ORDERS']?></td>
								</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</main><!-- .content -->
</div><!-- .wrapper -->
<?php include_once '../include/footer.php'; ?>
</body>
</html>