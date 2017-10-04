<?
var_dump(1);
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");
$APPLICATION->SetPageProperty("title", "404 Not Found");
?>

      <main class="content container">
        <div class="content-page page-404 font-fix">
          <h1><?=GetMessage("404_error");?></h1>
          <div class="status-icon icon-404"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/404.svg"></div>
          <div class="status-title"><?=GetMessage("404_we_dont_have_this_fckng_page");?></div><a href="<?=SITE_DIR?>" class="to-root"><?=GetMessage("404_back_index");?></a>
        </div>
      </main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>