<?php
use Bd\Deliverypizza;
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/orders.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/common.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/data.php';
global $USER;
if(!isset($_GET['filter_preset']) && !isset($_GET['date_start']) && !isset($_GET['query']))
	LocalRedirect(SITE_DIR.'crm/?filter_preset=today');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title><?php echo GetMessage("orders_crm"); ?></title>
	<?php include_once 'include/head.php'; ?>
	<script type="text/javascript">
		<?php if(!empty($hasSmsSettings)): ?>
			window.has_sms = 1;
		<?php else: ?>
			window.has_sms = 0;
		<?php endif; ?>
		
		window.new_orders = 0;
		window.new_order_sound = '<?=SITE_DIR?>crm/static/sounds/<?=COption::GetOptionString('bd.deliverypizza','BD_CF_CRM_NEW_ORDER_SOUND','',SITE_ID);?>';
		$(document).ready(function(){
			window.favicon=new Favico({animation:'none',position: 'up'});
			setInterval(function(){
				$.ajax({
					url:window.location.href.replace(window.location.hash,''),
					data: {is_ajax: 1},
					dataType: 'json',
					success:function(data) {
						$('.orders-foot__summa .summ').html(number_format(data.orders_sum, 0, '.', ' ')+' <span class="currency">'+window.currency_f+'</span>')
						$.each(data.orders,function(i,item){
							if($('.orders-line[data-order="'+item.ID+'"]').length == 0){
								renderOrderLine(item);
								window.new_orders++;
								var sp = new Audio(window.new_order_sound).play();
								setTimeout(function(){
									$('.orders-line__send-mail').each(function(i,item) {
										var $id = $(this).closest('.orders-line').attr('data-order');
										var onS = function(e){
											$('#sms-accept-popover input[name="ORDER_ID"]').val($id);
											$('#sms-accept-popover input[name="PHONE"]').val($('.orders-line[data-order="'+$id+'"]').attr('data-phone'));
											$('.send-state').show();
											$('.sent-state').hide();
											$('.not-sent-state').hide();
										};
										$(item).webuiPopover({id_:$(item).attr('data-id'),url: '#'+$(item).attr('data-id'), cache: false,onShow: onS});
									});
								},1000);
							}else{
								var $order = $('.orders-line[data-order="'+item.ID+'"]');
								$order.find('.orders-line__name p').text(item.USER_NAME);
								$order.find('.orders-line__status').attr('class','orders-line__status orders-line__status--'+item.STATUS).text(item.STATUS_NAME);
								$order.find('.orders-line__phone p').text(item.USER_PHONE);
								$order.find('.orders-line__summa p span').first().text(number_format(item.ORDER_SUM, 0, '.', ' '));
								$order.attr('class','orders-line order-status-'+item.STATUS)
							}
						})
					}
				});
				if(window.new_orders > 0){
					$('title').text('*'+window.new_orders+' '+plural(window.new_orders,'<?php echo GetMessage("new"); ?>','<?php echo GetMessage("b_new"); ?>','<?php echo GetMessage("b_new"); ?>')+' '+plural(window.new_orders,'<?php echo GetMessage("order"); ?>','<?php echo GetMessage("ordera"); ?>','<?php echo GetMessage("orders"); ?>'));
				}else{
					$('title').text('<?php echo GetMessage("orders_crm"); ?>');
				}
				window.favicon.badge(window.new_orders);
			},3000);
		})
	</script>
</head>
<body>

<div class="wrapper">
<?php require_once 'include/header.php';?>

<div class="filter-line">
	<div class="wrap">
		<div class="row">
			<div class="filter-line__left">
				<form action="" method="get">

					<div class="search-field">
						<input type="text" class="search default" placeholder="<?php echo GetMessage("search_orders"); ?>" name="query" value="<?=(isset($_GET['query']))?$_GET['query']:''?>">
						<button type="submit"></button>
					</div>
					<div class="date-filter">
						<div class="date-filter__title"><?php echo GetMessage("filter"); ?></div>
						<input onclick="BX.calendar({node:this, field:this, bHideTime: true, bTime: false});" type="text" class="default"  value="<?=(isset($_GET['date_start']))?$_GET['date_start']:''?>" placeholder="__.__.____" name="date_start">
						<div class="date-filter__delimiter">&#8211;</div>
						<input  value="<?=(isset($_GET['date_end']))?$_GET['date_end']:''?>" type="text" onclick="BX.calendar({node:this, field:this, bHideTime: true,bTime: false});" class="default" placeholder="__.__.____" name="date_end">
						<input type="submit" class="apply-filter <?php if(!isset($_GET['date_start']) && !isset($_GET['date_end'])  || empty($_GET['date_start']) && empty($_GET['date_end'])): ?>disabled<?php endif; ?>" <?php if(!isset($_GET['date_start']) && !isset($_GET['date_end'])  || empty($_GET['date_start']) && empty($_GET['date_end'])): ?>disabled="disabled"<?php endif; ?> value="<?php echo GetMessage("apply"); ?>">
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
		<div class="orders-page">
			<div class="period-nav">
				<span><?php echo GetMessage("show_period"); ?></span>
				<a <?php if(isset($_GET['filter_preset']) && $_GET['filter_preset']=='last_week'): ?>class="active"<?php endif; ?> href="<?=SITE_DIR?>crm/?filter_preset=last_week"><span class="prev"></span> <?php echo GetMessage("week"); ?></a>
				<a <?php if(isset($_GET['filter_preset']) && $_GET['filter_preset']=='yesterday'): ?>class="active"<?php endif; ?> href="<?=SITE_DIR?>crm/?filter_preset=yesterday"><?php echo GetMessage("yesterday"); ?></a>
				<a <?php if(isset($_GET['filter_preset']) && $_GET['filter_preset']=='today'): ?>class="active"<?php endif; ?> href="<?=SITE_DIR?>crm/?filter_preset=today"><?php echo GetMessage("today"); ?></a>
				<a <?php if(isset($_GET['filter_preset']) && $_GET['filter_preset']=='tomorrow'): ?>class="active"<?php endif; ?> href="<?=SITE_DIR?>crm/?filter_preset=tomorrow"><?php echo GetMessage("tomorrow"); ?></a>
				<a <?php if(isset($_GET['filter_preset']) && $_GET['filter_preset']=='next_week'): ?>class="active"<?php endif; ?> href="<?=SITE_DIR?>crm/?filter_preset=next_week"><?php echo GetMessage("week"); ?> <span class="next"></span></a>
			</div><!-- .period-nav -->
			<div class="orders-list">
			<?php $ordersSum = 0;
					$hasSmsSettings = \COption::GetOptionString('bd.deliverypizza','BD_CF_AUTH_SMS_LOGIN', '', SITE_ID);
			?>
			<?php foreach($orders as $order): ?>
				<?php

				$ordersSum += $order['ORDER_SUM']; ?>
				<div class="orders-line order-status-<?=$order['STATUS']?>" data-order="<?=$order['ID'];?>" data-username="<?=$order['USER_NAME']?>" data-phone="<?=$order['USER_PHONE']?>" data-sum="<?=$order['ORDER_SUM']?>" data-address="<?=GetMessage("street").' '.$order['STREET'].' '.GetMessage("home").' '.$order['HOUSE'].' '.GetMessage("appartaments").' '.$order['APARTMENT']?>" data-order-date="<?=date('d.m.Y H:i',$order['ORDER_DATE']);?>" data-status="<?=Deliverypizza\Models\Order::$statuses[$order['STATUS']]['name'];?>">
					
					<div onclick="viewUser(<?=$order['USER_ID']?>)" class="orders-line__num user<?=$order['USER_ID']?> <?php if($order['VIP']==1):?>orders-line__num--vip<?php endif; ?>"><span></span><a href="#client-<?=$order['USER_ID']?>" ><?=$order['ID'];?></a></div>
					
					<?php if(!empty($hasSmsSettings)): ?>
					<div data-id="<?php if($order['SEND_SMS']==1):?>sms-accept-popover<?php else: ?>sms-decline-popover<?php endif; ?>" data-placement="left" data-handler="popover" class="orders-line__send-mail <?php if($order['SEND_SMS']==1):?>send-mail-active<?php else: ?>send-mail-disable<?php endif; ?>"><span></span></div>
					<?php endif; ?>
					<div class="orders-line__show-card <?php if(empty($hasSmsSettings)):?>sms_disabled<?php endif; ?>" onclick="viewOrder(<?=$order['ID'];?>);"><?php echo GetMessage("see_order"); ?></div>
					<div class="orders-line__info">
						<div class="orders-line__status orders-line__status--<?=$order['STATUS']?>"><?=Deliverypizza\Models\Order::$statuses[$order['STATUS']]['name']?></div>
						<div class="orders-line__about-out">
							<div class="orders-line__about">
								<div class="orders-line__date">
									<div class="title"><?php echo GetMessage("date"); ?></div>
									<p><?=date('d.m.y (H:i)',$order['ORDER_DATE'])?></p>
								</div>
								<div class="orders-line__name">
									<div class="title"><?php echo GetMessage("name"); ?></div>
									<p><?=$order['USER_NAME']?></p>
								</div>
								<div class="orders-line__phone">
									<div class="title"><?php echo GetMessage("phone"); ?></div>
									<p><?=$order['USER_PHONE']?></p>
								</div>
								<div class="orders-line__summa">
									<div class="title"><?php echo GetMessage("sum"); ?></div>
									<p><span><?=number_format($order['ORDER_SUM'],0 ,'.',' ')?></span><span class="currency"><?=CURRENCY_FONT?></span></p>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .orders-line -->
			<?php endforeach; ?>
			</div>
			<div class="paginator">
				<?=paginate(10,(isset($_GET['page'])?$_GET['page']:1),$ordersCount,ceil($ordersCount/10),SITE_DIR.'crm/');?>
			</div><!-- .paginator -->
			<div class="orders-foot">
				<div class="orders-foot__info">
					<p><?php echo GetMessage("vip_text"); ?></p>
					<p><?php echo GetMessage("bonuses_text"); ?></p>
				</div>
				<div class="orders-foot__summa">
					<div class="title"><?php echo GetMessage("all_sum"); ?></div>
					<div class="summ"><?=number_format($orders_total,0 ,'.',' ')?><span class="currency"><?=CURRENCY_FONT?></span></div>
				</div>
			</div><!-- .orders-foot -->
		</div>
	</div>
</main><!-- .content -->

</div>
</div>

<?php include_once 'include/footer.php'; ?>
</body>
</html>
