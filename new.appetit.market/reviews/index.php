<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Отзывы");
$APPLICATION->SetTitle("Отзывы");
?>
<div class="grey-fw-container">
        <div class="container">
          <div class="row products-sub-menu font-fix">

          </div>
        </div>
      </div>
<?$APPLICATION->IncludeComponent(
	"khayr:main.comment",
	"reviews",
	array(
		"OBJECT_ID" => "1",
		"COUNT" => "50",
		"MAX_DEPTH" => "2",
		"JQUERY" => "N",
		"MODERATE" => "Y",
		"LEGAL" => "N",
		"LEGAL_TEXT" => "Я согласен с правилами размещения сообщений на сайте.",
		"CAN_MODIFY" => "N",
		"NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
		"REQUIRE_EMAIL" => "Y",
		"USE_CAPTCHA" => "Y",
		"AUTH_PATH" => "/auth/",
		"ACTIVE_DATE_FORMAT" => "j F Y, G:i",
		"LOAD_AVATAR" => "N",
		"LOAD_MARK" => "N",
		"LOAD_DIGNITY" => "N",
		"LOAD_FAULT" => "N",
		"ADDITIONAL" => array(
		),
		"ALLOW_RATING" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"COMPONENT_TEMPLATE" => "reviews",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>