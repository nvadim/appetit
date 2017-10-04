<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bd\Deliverypizza;
$this->setFrameMode(true);


if ($arParams["SECTION_ID"]):
	$res = CIBlockSection::GetByID($arParams["SECTION_ID"]);

	$rsSect = CIBlockSection::GetList(
		array('left_margin' => 'asc'),
		array(
			"IBLOCK_ID"=>\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
			"ID" => $arParams["SECTION_ID"]
		),
		false,
		array("NAME", "IBLOCK_ID", "SECTION_PAGE_URL", "UF_ICON_TITLE")
	);

	if ($arSect = $rsSect->GetNext())
	{
		$arSect["ICON_TITLE_URL"] = CFile::GetPath($arSect["UF_ICON_TITLE"]);
		$arResult["SECTION"] = $arSect;
	}

	$res = CIBlockElement::GetList(
		array(),
		array(
			"IBLOCK_ID"=>\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"SECTION_ID" => $arParams["SECTION_ID"],
			"SECTION_GLOBAL_ACTIVE" => "Y",
			"INCLUDE_SUBSECTIONS" => "Y"
		),
		false,
		array("nPageSize"=>50),
		array("ID", "NAME", "PROPERTY_RECOMEND")
	);

	while($ob = $res->GetNext())
	{
	    $items_ids[] = $ob['ID'];
	}
?>

	<?php if(!empty($items_ids)): ?>
		<?if ($arParams["HIDE_TITLE"] != "Y"):?>
			<?if ($arResult["SECTION"]["ICON_TITLE_URL"]):?>
				<h4 style="background-image: url(<?=$arResult["SECTION"]["ICON_TITLE_URL"]?>)" class="product-list-title icon"><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=$arResult["SECTION"]["NAME"]?></a>
					<a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" class="button-show-all">Посмотреть все</a>
				</h4>
			<?else:?>
				<h4 class="product-list-title"><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=$arResult["SECTION"]["NAME"]?></a></h4>
			<?endif?>
		<?endif?>
		<div class="row product-list<?if ($arParams["NOT_SLIDER"] != "Y"):?> responsive-slider<?endif?> show">
		<?
		global $arrFilterCategory;
		$arrFilterCategory['ID'] = $items_ids;

		$APPLICATION->IncludeComponent(
			"bitrix:catalog.top",
			"",
			array(
				"FILTER_NAME" => "arrFilterCategory",
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ELEMENT_SORT_FIELD" => "SORT",
				"ELEMENT_SORT_ORDER" => "ASC",
				"ELEMENT_SORT_FIELD2" => "NAME",
				"ELEMENT_SORT_ORDER2" => "ASC",
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
				"ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
				"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
				"PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
				'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
				'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
				'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
				'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
				'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
				'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
				'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
				'ADD_TO_BASKET_ACTION' => $basketAction,
				'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
			),
			$component
		);?>
		</div>
	<?php endif; ?>
<?endif?>