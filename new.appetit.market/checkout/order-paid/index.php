<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Ваш заказ оплачен");
$APPLICATION->SetTitle("Ваш заказ оплачен");
?>

      <main class="content container">
        <div class="content-page page-payment-success font-fix">
          <h1><?=GetMessage("paid_title");?><?=$_SESSION['last_order'];?></h1>
          <div class="status-icon icon-payment-success"><img src="<?echo SITE_TEMPLATE_PATH ?>/images/item_pay.svg"></div>
          <div class="status-title"><?=GetMessage("paid_thanks_title");?></div>
          <div class="status-text"><?=GetMessage("paid_thanks_desc");?></div>
          <a href="<?=SITE_DIR?>" class="to-root"><?=GetMessage("paid_back");?></a>
        </div>
      </main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>