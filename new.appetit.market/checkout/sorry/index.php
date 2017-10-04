<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Произошла ошибка во время оплаты заказа");
$APPLICATION->SetTitle("Произошла ошибка во время оплаты заказа");
?>

      <main class="content container">
        <div class="content-page page-payment-fail font-fix">
          <h1><?=GetMessage("fail_title");?><?=$_SESSION['last_order'];?></h1>
          <div class="status-icon icon-payment-fail"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/item_not_pay.svg"></div>
          <div class="status-title"><?=GetMessage("fail_second_title");?></div>
          <div class="status-text"><?=GetMessage("fail_desc");?></div>
          <a href="/payment-init.php?order=<?=$_SESSION['last_order']?>" class="to-root"><?=GetMessage("fail_pay");?></a>
        </div>
      </main>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bd.deliverypizza/controller/payment_fail.php';?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>