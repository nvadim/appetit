<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (intval($arResult["PROPERTIES"]["SECTION_GOODS"]["VALUE"])):?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog",
		"category_items",
		array(
			"COMPONENT_TEMPLATE" => "category_items",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
			"TEMPLATE_THEME" => "blue",
			"ADD_PICT_PROP" => "-",
			"LABEL_PROP" => "-",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_COMPARE" => "Сравнение",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"DETAIL_USE_VOTE_RATING" => "N",
			"DETAIL_USE_COMMENTS" => "N",
			"DETAIL_BRAND_USE" => "N",
			"SIDEBAR_SECTION_SHOW" => "N",
			"SIDEBAR_DETAIL_SHOW" => "N",
			"SIDEBAR_PATH" => "",
			"SEF_MODE" => "Y",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"SET_LAST_MODIFIED" => "N",
			"SET_TITLE" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"ADD_ELEMENT_CHAIN" => "N",
			"USE_FILTER" => "N",
			"FILTER_VIEW_MODE" => "VERTICAL",
			"INSTANT_RELOAD" => "N",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"USE_COMPARE" => "N",
			"PRICE_CODE" => array(
			),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "N",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"BASKET_URL" => "/personal/basket.php",
			"USE_PRODUCT_QUANTITY" => "N",
			"PRODUCT_QUANTITY_VARIABLE" => "",
			"ADD_PROPERTIES_TO_BASKET" => "N",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRODUCT_PROPERTIES" => array(
			),
			"SHOW_TOP_ELEMENTS" => "Y",
			"SECTION_COUNT_ELEMENTS" => "N",
			"SECTION_TOP_DEPTH" => "2",
			"SECTIONS_VIEW_MODE" => "LIST",
			"SECTIONS_SHOW_PARENT_NAME" => "N",
			"PAGE_ELEMENT_COUNT" => "50",
			"LINE_ELEMENT_COUNT" => "3",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER2" => "desc",
			"LIST_PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"INCLUDE_SUBSECTIONS" => "Y",
			"LIST_META_KEYWORDS" => "-",
			"LIST_META_DESCRIPTION" => "-",
			"LIST_BROWSER_TITLE" => "-",
			"SECTION_BACKGROUND_IMAGE" => "-",
			"DETAIL_PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"DETAIL_META_KEYWORDS" => "-",
			"DETAIL_META_DESCRIPTION" => "-",
			"DETAIL_BROWSER_TITLE" => "-",
			"DETAIL_SET_CANONICAL_URL" => "N",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
			"DETAIL_BACKGROUND_IMAGE" => "-",
			"SHOW_DEACTIVATED" => "N",
			"DETAIL_DISPLAY_NAME" => "Y",
			"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
			"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
			"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
			"LINK_IBLOCK_TYPE" => "",
			"LINK_IBLOCK_ID" => "",
			"LINK_PROPERTY_SID" => "",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
			"USE_STORE" => "N",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"USE_ELEMENT_COUNTER" => "N",
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",
			"TOP_ELEMENT_COUNT" => "50",
			"TOP_LINE_ELEMENT_COUNT" => "4",
			"TOP_ELEMENT_SORT_FIELD" => "sort",
			"TOP_ELEMENT_SORT_ORDER" => "asc",
			"TOP_ELEMENT_SORT_FIELD2" => "id",
			"TOP_ELEMENT_SORT_ORDER2" => "desc",
			"TOP_PROPERTY_CODE" => array(
				0 => "",
				1 => "OLD_PRICE",
				2 => "PRICE",
				3 => "G",
				4 => "RECOMEND",
				5 => "UNITS",
				6 => "INGREDIENTS",
				7 => "LIKE_COUNTER",
				8 => "NO_SALE",
				9 => "BUY_IT",
				10 => "BUY_IT_COMPLETE",
				11 => "BD_PROPS_1",
				12 => "BD_PROPS_2",
				13 => "BADGES",
				14 => "BD_PROPS",
				15 => "",
			),
			"TOP_VIEW_MODE" => "SECTION",
			"SEF_FOLDER" => "/menu/",
			"SECTION_ID" => intval($arResult["PROPERTIES"]["SECTION_GOODS"]["VALUE"]),
			"DETAIL_STRICT_SECTION_CHECK" => "N",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"COMPATIBLE_MODE" => "Y",
			"SEF_URL_TEMPLATES" => array(
				"sections" => "",
				"section" => "#SECTION_CODE_PATH#/",
				"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
				"compare" => "",
				"smart_filter" => "",
			),
			"HIDE_TITLE" => "Y",
			"NOT_SLIDER" => "Y"
		),
		false
	);?>
<?endif?>
<div class="news-detail" itemscope itemtype="http://schema.org/Article">
			<div class="hidden-xs-up" itemprop="headline name"><?php echo $arResult['NAME']; ?></div>
			<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
				<span class="news-date-time" itemprop="datePublished" content="<?php echo date('Y-m-d',strtotime($arItem["PROPERTIES"]['DATE']["VALUE"])); ?>"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
			<?endif;?>
			<div class="detail-content" itemprop="articleBody">
				<p><?=$arResult["DETAIL_TEXT"];?></p>
			</div>
			<?php if(!empty($arResult['DETAIL_PICTURE'])): ?>
				<div class="news-detail-image">
					<img src="<?php echo $arResult['DETAIL_PICTURE']['SRC']; ?>" alt="<?php echo $arResult['NAME']; ?>" title="<?php echo $arResult['NAME']; ?>">
				</div>
			<?php endif; ?>
			<div></div>
			<?php if($arResult['PROPERTIES']['ADDITIONAL_PHOTOS']['VALUE'] && empty($arResult['PROPERTIES']['RELATED_PRODUCT']['VALUE'])): ?>
				<div class="row additional-photos">
					<?php foreach($arResult['PROPERTIES']['ADDITIONAL_PHOTOS']['VALUE'] as $photo_): ?>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6 additional-photo-item">
						<?php
						$photo = CFile::ResizeImageGet($photo_, array('width'=>'348', 'height'=>'269'), BX_RESIZE_IMAGE_EXACT, true);
						$full = CFile::GetFileArray($photo_);
						?>
						<a class="fancybox preview_" rel="gallery1" href="<?=CUtil::GetAdditionalFileURL($full['SRC']);?>">
							<div class="overlay"><div class="zoom-btn"></div></div>
						<img src="<?=CUtil::GetAdditionalFileURL($photo['src']);?>" alt="">
						</a>
					</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if($arResult['PROPERTIES']['RELATED_PRODUCT']['VALUE']): ?>
				<div class="row additional-photos">
					<?php foreach($arResult['PROPERTIES']['RELATED_PRODUCT']['VALUE'] as $pid): ?>
						<?php
						$res = CIBlockElement::GetByID($pid);
						if($ar_res = $res->GetNext())
							 $product = $ar_res;
						?>

						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6 additional-photo-item related-product">
							<a href="<?=$product['DETAIL_PAGE_URL'];?>" title="<?=$product['NAME'];?>" data-id="<?=$product['ID'];?>" data-modal="product-detail" class="preview_ md-trigger">
								<div class="overlay"><div class="zoom-btn"></div></div>
								<?php
								if($product['PREVIEW_PICTURE']):
								$photo = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width'=>'349', 'height'=>'269'), BX_RESIZE_IMAGE_EXACT, true);?>
								<img src="<?=CUtil::GetAdditionalFileURL($photo['src']);?>" alt="<?=$product['NAME'];?>" title="<?=$product['NAME'];?>">
								<?php else: ?>
									<img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo.jpg">
								<?php endif; ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		<div class="back-to-catalog font-fix"><a href="/menu/"><span class="go-back">Перейти в основное меню</span></a></div>
</div>