<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Спасибо за заказ");
$APPLICATION->SetTitle("Спасибо за заказ");
?>

      <main class="content container">
        <div class="content-page page-payment-success font-fix">
          <h1><?=GetMessage("success_title");?><?=$_SESSION['last_order'];?></h1>
          <div class="status-icon icon-payment-success"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/item_pay.svg"></div>
          <div class="status-title"><?=GetMessage("success_thanks_title");?></div>
          <div class="status-text"><?=GetMessage("success_thanks_desc");?></div>
          <a href="<?=SITE_DIR?>" class="to-root"><?=GetMessage("success_back");?></a>
        </div>
      </main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>