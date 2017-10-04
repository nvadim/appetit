<?php
use Bd\Deliverypizza;
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/common.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/users.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/orders.php';
include $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/crm/data.php';
global $USER;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?php echo GetMessage("clients_crm"); ?></title>
	<?php include_once '../include/head.php'; ?>
</head>
<body>
<div class="wrapper">
	<?php require_once '../include/header.php';?>
	<div class="filter-line">
		<div class="wrap">
			<div class="row">
				<div class="filter-line__left">
					<form action="" method="get">
						<div class="search-field">
							<input type="text" class="search default" placeholder="<?php echo GetMessage("search_clients"); ?>" name="query" value="<?=(isset($_GET['query']))?$_GET['query']:''?>">
							<button type="submit"></button>
						</div>

					</form>
				</div>
				<div class="filter-line__right">
					<div class="sort-by">
						<div class="sort-by__title"><?php echo GetMessage("sort"); ?></div>
						<div class="sort-by__select">
							<select class="basic" onchange="window.location.href='<?=SITE_DIR?>crm/clients/?sort='+$(this).val();">
								<option <?=(isset($_GET['sort']) && $_GET['sort']=='ID')?'selected':''; ?> value="ID"><?php echo GetMessage("reg_date"); ?></option>
								<option <?=(isset($_GET['sort']) && $_GET['sort']=='LAST_ORDER')?'selected':''; ?> value="LAST_ORDER"><?php echo GetMessage("order_date"); ?></option>
								<option <?=(isset($_GET['sort']) && $_GET['sort']=='ORDERS_COUNT')?'selected':''; ?> value="ORDERS_COUNT"><?php echo GetMessage("orders_sum"); ?></option>
								<option <?=(isset($_GET['sort']) && $_GET['sort']=='ORDERS_SUM')?'selected':''; ?> value="ORDERS_SUM"><?php echo GetMessage("sum_spend"); ?></option>
								<option <?=(isset($_GET['sort']) && $_GET['sort']=='VIP')?'selected':''; ?> value="VIP"><?php echo GetMessage("vip"); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</header><!-- .header-->
	<main class="content">
		<div class="wrap">
			<div class="client-page">
				<div class="client-list">
					<?php foreach($users as $user): ?>
					<div class="client-line">
						<div class="client-line__show-card" onclick="viewUser(<?=$user['USER_ID'];?>)"><?php echo GetMessage("view"); ?></div>
						<div class="client-line__about-out">
							<div class="client-line__about">
								<div class="client-line__id">
									<div class="title"><?php echo GetMessage("id"); ?></div>
									<p><?=$user['USER_ID']?></p>
								</div>
								<div class="client-line__name">
									<div class="title"><?php echo GetMessage("name"); ?></div>
									<p><?=(!empty($user['NAME']))?$user['NAME']:GetMessage("not_used");?></p>
								</div>
								<div class="client-line__phone">
									<div class="title"><?php echo GetMessage("phone"); ?></div>
									<p><?=(!empty($user['PHONE']))?$user['PHONE']:GetMessage("not_use");?></p>
								</div>
								<div class="client-line__last-order">
									<div class="title"><?php echo GetMessage("last_order"); ?></div>
									<p><?=(isset($user['LAST_ORDER']))?$user['LAST_ORDER']:GetMessage("not_order");?></p>
								</div>
								<div class="client-line__order-number">
									<div class="title"><?php echo GetMessage("orders"); ?></div>
									<p><?=$user['ORDERS_COUNT']?></p>
								</div>
								<div class="client-line__summa">
									<div class="title"><?php echo GetMessage("sum_spend"); ?></div>
									<p><?=number_format($user['ORDERS_SUM'],0 ,'.',' ')?><span class="currency"><?=CURRENCY_FONT?></span></p>
								</div>
							</div>
						</div>
					</div><!-- .client-line -->
					<?php endforeach; ?>
				</div><!-- .client-list -->
				<div class="paginator">
					<?=paginate(10,(isset($_GET['page'])?$_GET['page']:1),$usersCount,ceil($usersCount/10),SITE_DIR.'/crm/clients/');?>
				</div><!-- .paginator -->

			</div>
		</div>
	</main><!-- .content -->

</div>
</div>
<?php include_once '../include/footer.php'; ?>

</body>
</html>
