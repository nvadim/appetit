<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Конструктор пиццы");
$APPLICATION->SetTitle("Конструктор пиццы");

if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
      <div class="content">
        <div class="status-bar"><a href="/catalog/" onclick="getConstructorView('main')" class="back"></a>
          <div class="title"><?echo strip_tags($APPLICATION->GetTitle())?></div>
        </div>
<?$APPLICATION->IncludeComponent(
	"bd:constructor_pizza", 
	"mobile", 
	array(
		"COMPONENT_TEMPLATE" => "mobile",
		"IBLOCK_ID_BASE" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_base"][0],
		"IBLOCK_ID_SOUS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_souce"][0],
		"IBLOCK_ID_BOX" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_ready"][0],
		"IBLOCK_ID_INGREDIENTS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_ingredients"][0],
		"USE_BOX" => "Y"
	),
	false
);
?>
</div>
<?php else:?><!---Основная версия сайта ---->
      <main class="content container">
        <div class="row">
          <div class="col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div> 
        </div>
<?$APPLICATION->IncludeComponent(
	"bd:constructor_pizza", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID_BASE" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_base"][0],
		"IBLOCK_ID_SOUS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_souce"][0],
		"IBLOCK_ID_BOX" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_ready"][0],
		"IBLOCK_ID_INGREDIENTS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_pizza_constructor"]["bd_pizza_ingredients"][0],
		"USE_BOX" => "Y",
		"IBLOCK_TYPE_BASE" => "-",
		"IBLOCK_TYPE_SOUS" => "-",
		"IBLOCK_TYPE_BOX" => "-",
		"IBLOCK_TYPE_INGREDIENTS" => "-"
	),
	false
);
?>
      </main>
<?php endif;?> 

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>