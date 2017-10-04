<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Подарки");
$APPLICATION->SetTitle("Подарки");
?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)): ?>
<div class="content">
         <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_GIFT_ENABLED','',SITE_ID) == 'Y'): ?>
        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"gifts",
	array(
		"COMPONENT_TEMPLATE" => "gifts",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_gifts_pizza"]["bd_gifts"][0],
		"NEWS_COUNT" => "999",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "STICKER",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"FILE_404" => "/404.php",
		"MESSAGE_404" => ""
	),
	false
);?>
        <?php else: ?>
	  <div class="content-page page-404 font-fix error_text page-403">
	    <div class="status-title"><?=GetMessage("gift_module_not_avaible");?></div>
	  </div>
	<?php endif; ?>
	<footer class="font-fix">
	<?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "bottom",
        array(
            "ROOT_MENU_TYPE" => "bottom_mob",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => array(
            ),
            "MAX_LEVEL" => "1",
            "CHILD_MENU_TYPE" => "bottom_mob",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "COMPONENT_TEMPLATE" => "menu"
        ),
        false
    );?>
	<div class="container">
		<div class="text-block">
			<div class="phone"><a href="tel:<?=preg_replace('/\D/', '', \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID))?>"><?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID) ?></a></div>
			<div class="phone-desc"><?=GetMessage("delivery_fcng_awesome");?></div>
		</div>
		<div class="social-icons-footer">
<?$APPLICATION->IncludeComponent("bd:social", ".default", Array(
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
		</div>
	</div>
</footer>
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
        <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_GIFT_ENABLED','',SITE_ID) == 'Y'): ?>
        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"gifts",
	array(
		"COMPONENT_TEMPLATE" => "gifts",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_gifts_pizza"]["bd_gifts"][0],
		"NEWS_COUNT" => "999",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "STICKER",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"FILE_404" => "/404.php",
		"MESSAGE_404" => ""
	),
	false
);?>
        <?php else: ?>
	  <div class="content-page page-404 font-fix error_text page-403">
	    <div class="status-title"><?=GetMessage("gift_module_not_avaible");?></div>
	  </div>
	<?php endif; ?>
      </main>
<?php endif; ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>