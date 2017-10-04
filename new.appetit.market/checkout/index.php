<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
$APPLICATION->SetTitle("Оформление заказа");

if (($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET'] == false)): ?>
    <div class="content">
        <? $APPLICATION->IncludeComponent(
            "bd:checkout_pizza",
            "mobile",
            array(
                "COMPONENT_TEMPLATE" => "mobile",
                "IBLOCK_ID_PAY_METHOD" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_paymethod"][0],
                "IBLOCK_ID_DESTRICT" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0],
                "IBLOCK_ID_TAKE_AWAY" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_takeaway"][0]
            ),
            false
        );
        ?>
    </div>
<? else:?><!---ќсновна€ верси€ сайта ---->
    <main class="content container">
        <div class="row">
            <div class="col-lg-12 breadcrumb-box">
                <h1 class="font-fix"><? echo strip_tags($APPLICATION->GetTitle()) ?></h1>
                <div class="breadcrumb-container font-fix">
                    <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false); ?>
                </div>
            </div>
        </div>
        <?
//        $APPLICATION->IncludeComponent(
//        	"bd:checkout_pizza",
//        	".default",
//        	array(
//        		"COMPONENT_TEMPLATE" => ".default",
//        		"IBLOCK_ID_PAY_METHOD" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_paymethod"][0],
//        		"IBLOCK_ID_DESTRICT" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0],
//        		"IBLOCK_ID_TAKE_AWAY" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_takeaway"][0]
//        	),
//        	false
//        );
        ?>
        <? $APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"order", 
	array(
		"COMPONENT_TEMPLATE" => "order",
		"PAY_FROM_ACCOUNT" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "N",
		"ALLOW_APPEND_ORDER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "N",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",
		"DELIVERY_NO_SESSION" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"SPOT_LOCATION_BY_GEOIP" => "Y",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"SHOW_VAT_PRICE" => "Y",
		"USE_PREPAYMENT" => "N",
		"COMPATIBLE_MODE" => "Y",
		"USE_PRELOAD" => "Y",
		"ALLOW_USER_PROFILES" => "N",
		"ALLOW_NEW_PROFILE" => "N",
		"TEMPLATE_THEME" => "blue",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "Y",
		"SKIP_USELESS_BLOCK" => "N",
		"BASKET_POSITION" => "after",
		"SHOW_BASKET_HEADERS" => "N",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "Y",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"SHOW_NEAREST_PICKUP" => "N",
		"DELIVERIES_PER_PAGE" => "9",
		"PAY_SYSTEMS_PER_PAGE" => "9",
		"PICKUPS_PER_PAGE" => "5",
		"SHOW_PICKUP_MAP" => "N",
		"SHOW_MAP_IN_PROPS" => "N",
		"PICKUP_MAP_TYPE" => "yandex",
		"PROPS_FADE_LIST_1" => array(
		),
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"ACTION_VARIABLE" => "soa-action",
		"PATH_TO_BASKET" => "",
		"PATH_TO_PERSONAL" => "/my/",
		"PATH_TO_PAYMENT" => "",
		"PATH_TO_AUTH" => "/auth/",
		"SET_TITLE" => "Y",
		"DISABLE_BASKET_REDIRECT" => "Y",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
		),
		"ADDITIONAL_PICT_PROP_47" => "-",
		"ADDITIONAL_PICT_PROP_59" => "-",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"SERVICES_IMAGES_SCALING" => "adaptive",
		"PRODUCT_COLUMNS_HIDDEN" => array(
		),
		"USE_YM_GOALS" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N"
	),
	false
); ?>
    </main>
<?php endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>