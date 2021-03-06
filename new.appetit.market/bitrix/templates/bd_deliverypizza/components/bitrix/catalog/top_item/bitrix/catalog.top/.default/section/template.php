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
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
$this->setFrameMode(true);
?>
	<!--RestartBuffer-->
	<?
	if(isset($_GET['AJAX_PAGE'])) { $APPLICATION->RestartBuffer(); }

foreach($arResult["ITEMS"] as $arItem):

	 $arItem["OLD_PRICE"] = $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];
	 $arItem["PRICE"] = $arItem["PROPERTIES"]["PRICE"]["VALUE"];
	 $arItem["G"] = $arItem["PROPERTIES"]["G"]["VALUE"];
	 $arItem["G_UNITS"] = $arItem["PROPERTIES"]["UNITS"]["VALUE"];

 ?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

<?if($arItem["PROPERTIES"]['BANNER']["VALUE"]):?>
	<div class="col-lg-3 col-xl-3 col-sm-6 product-ajax-cont <?php if(isset($_GET['AJAX_PAGE'])): ?>animate<?php endif; ?>">
		<div data-id="<?=$arItem['ID'];?>" class="product banner" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?
				$Banner =  CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width'=>'255', 'height'=>'455'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				$Banner2 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width'=>'222', 'height'=>'490'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				$Banner3 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width'=>'344', 'height'=>'560'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				$Banner4 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width'=>'275', 'height'=>'510'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				$Banner5 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width'=>'344', 'height'=>'645'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			?>
			<?if($arItem["PROPERTIES"]['BANNER_URL']["VALUE"]):?>
				<a href="<?=$arItem["PROPERTIES"]['BANNER_URL']["VALUE"]?>">
			<?endif;?>
			<picture>
				<source srcset="<?=CUtil::GetAdditionalFileURL($Banner5['src']);?>" media="(max-width: 554px)">
				<source srcset="<?=CUtil::GetAdditionalFileURL($Banner4['src']);?>" media="(max-width: 768px)">
				<source srcset="<?=CUtil::GetAdditionalFileURL($Banner3['src']);?>" media="(max-width: 991px)">
				<source srcset="<?=CUtil::GetAdditionalFileURL($Banner2['src']);?>" media="(max-width: 1199px)">
				<source srcset="<?=CUtil::GetAdditionalFileURL($Banner['src']);?>"  media="(max-width: 2000px)">

				<img
					srcset="<?=CUtil::GetAdditionalFileURL($Banner['src']);?>"
					itemprop="image"
					class="product-image"
				/>
			</picture>
			<?if($arItem["PROPERTIES"]['BANNER_URL']["VALUE"]):?>
				</a>
			<?endif;?>
			</div>
			</div>
<?else:?>
          <div class="col-lg-3 col-xl-3 col-sm-6">
            <div data-id="<?=$arItem['ID'];?>" itemscope itemtype="http://schema.org/Product" class="product" id="<?=$this->GetEditAreaId($arItem['ID']);?>"  data-unit="<?php echo $arItem['PROPERTIES']['UNITS']['VALUE']; ?>">
              <div data-modal="product-detail" class="preview md-trigger">
                   <?if($arItem["PROPERTIES"]['BADGES']["VALUE"]):?>
                   		<div class="product-labels">
                        	<?foreach ($arItem["BADGES"] as $key=>$Badges) :?>
                        		<div title="<?=$Badges['NAME']?>" class="product-label"><img src="<?=$Badges['ICON']?>"></div>
						 	<?endforeach?>
						 </div>
					<?endif;?>

                <?if($arItem['PREVIEW_PICTURE']):?>
                    <?
	                $MiniPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'254', 'height'=>'197'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                $MiniPhoto2 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'353', 'height'=>'275'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                $MiniPhoto3 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'553', 'height'=>'475'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                $MiniPhoto4 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'342', 'height'=>'265'), BX_RESIZE_IMAGE_PROPORTIONAL, true);

	                ?>
	                <picture>
		                <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto3['src']);?>" media="(max-width: 554px)">
		                <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto2['src']);?>" media="(max-width: 768px)">
		                <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto4['src']);?>" media="(max-width: 992px)">
		                <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" media="(max-width: 2000px)">

		                <img
			                srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>"
			                alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			                title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			                class="product-image"
		                />

	                </picture>
	              <a style="display: none;" itemprop="image" href="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" onclick="return false;"></a>
	                <?else:?>
	                    <img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo.jpg" itemprop="image" class="product-image">
	                <?endif;?>

                <div class="overlays">
                  <div class="zoom-btn"></div>
                </div>
	              <?php if($arItem['PROPERTIES']['NO_SALE']['VALUE']=='Y'):?><div title="<?=GetMessage("item_no_sale_title");?>" class="without-sale"></div><?php endif; ?>
	            <?Bd\Deliverypizza\UncachedArea::startCapture();?>
                <div class="likes">
                  <div class="like-content">
                    <div class="like-icon"></div><span>#LIKES#</span>
                  </div>
                </div>
	            <?$like_native = Bd\Deliverypizza\UncachedArea::endCapture();?>
	            <?Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $arItem, 'like_native'=>$like_native));?>
              </div>
              <div class="product-info"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="return false;" class="product-title font-fix"><span itemprop="name"><?=$arItem["NAME"]?></span></a>
                <div itemprop="description" class="product-description">
					<?=$arItem["PREVIEW_TEXT"]?>
                </div>
                <div class="product-options">
	              <?php  foreach($arItem['PROPS'] as $key=>$props): ?>
		              <div class="options-row-select col-xl-<?php echo 12/count($arItem['PROPS']); ?> col-lg-12 options-length-<?php echo count($arItem['PROPS']); ?>">
			              <select class="prop_">
				              <option value="null"><?php echo $key; ?></option>
				              <?php foreach($props as $j=>$val): ?>
					              <option value="<?php echo $j; ?>" data-price="<?php echo $val['PRICE']; ?>" data-old-price="<?php echo $val['OLD_PRICE']; ?>" data-weight="<?php echo $val['WEIGHT']; ?>"><?php echo $val['VALUE']; ?></option>
				              <?php endforeach; ?>
			              </select>
		              </div>
	              <?php endforeach; ?>
                </div>
                <?php if(!empty($arItem['MIN_PRICE']['VALUE']) && $arItem['MIN_PRICE']['VALUE']!=0): ?>
                    <? $haveOldPrice = $arItem['MIN_PRICE']['VALUE'] != $arItem['MIN_PRICE']['DISCOUNT_VALUE'];?>
                <div class="product-footer<?if($haveOldPrice):?><?else:?> base-price<?endif;?>">
                  <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="product-prices font-fix">

	                  <span class="old-price" <?if(!$haveOldPrice):?>style="display: none;" <?endif;?>>
	                  	<span class="line-through"><?=number_format($arItem['MIN_PRICE']['VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  </span>
	                  <span class="current-price"><span itemprop="price"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  <span itemprop="priceCurrency" class="text-hide"><?=CURRENCY_CODE?></span>
	                  </span>

	                  <span class="weight" <?if(!$arItem["G"]):?> style="display: none;"<?endif;?>><span><?=$arItem["G"]?></span><span> <?=$arItem["G_UNITS"]?></span></span>

	               </div>
                  <div class="product-actions <?php if(intval($arItem['PROPERTIES']['BUY_IT']['VALUE'])!==0 && $arItem['PROPERTIES']['BUY_IT']['VALUE']-$arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if(intval($arItem['PROPERTIES']['BUY_IT']['VALUE'])!==0 &&  ($arItem['PROPERTIES']['BUY_IT']['VALUE']-$arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] == 0 || $arItem['PROPERTIES']['BUY_IT']['VALUE']-$arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] < 0)): ?>progress-complete<?php endif; ?>">
	                  <?php
	                  $delta = Bd\Deliverypizza\Models\Product::GetProductDelta($arItem['ID']);
	                  if($delta<0) $delta = 0; ?>
	                  <?php if(!empty($arItem['PROPERTIES']['BUY_IT']['VALUE'])): ?>
		                  <?Bd\Deliverypizza\UncachedArea::startCapture();?>
		                  <div class="progress-container">
			                  <div style="width: #PERCENT#%;" class="progress-bar"></div>
			                  <div class="progress-bar-content font-fix">
				                  <div>#PLURAL#</div>
			                  </div>
		                  </div>
		                  <?$delta_ = Bd\Deliverypizza\UncachedArea::endCapture();?>
		                  <?Bd\Deliverypizza\UncachedArea::show('productDelta', array('id' => $arItem['ID'],'dc'=>$delta_));?>
	                  <?php endif;?>
	                  <?Bd\Deliverypizza\UncachedArea::startCapture();?>
	                  <a <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arItem['ID']; ?>" href="#" class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
	                  <?$buy = Bd\Deliverypizza\UncachedArea::endCapture();?>

	                  <?Bd\Deliverypizza\UncachedArea::startCapture();?>
	                  <a <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arItem['ID']; ?>" href="#" class="add-to-cart-btn native retry"><?=GetMessage("one_more_add_button");?></a>
	                  <?$inBasket = Bd\Deliverypizza\UncachedArea::endCapture();?>
	                  <?Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $arItem['ID'], 'buy' => $buy,'inBasket'=>$inBasket));?>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
<?endif;?>
<?endforeach;?>
<?php
$paramName = 'PAGEN_'.$arResult['NAV_RESULT']->NavNum;
$paramValue = $arResult['NAV_RESULT']->NavPageNomer;
$pageCount = $arResult['NAV_RESULT']->NavPageCount;

if ($paramValue < $pageCount) {
	$paramValue = (int) $paramValue + 1;
	$url = htmlspecialcharsbx(
		$APPLICATION->GetCurPageParam(
			sprintf('%s=%s', $paramName, $paramValue),
			array($paramName, 'AJAX_PAGE',)
		)
	);
	echo sprintf('<div class="ajax-pager-wrap">
                      <a class="ajax-pager-link" data-wrapper-class="product-list" href="%s"></a>
                  </div>',
		$url);
}
if(isset($_GET['AJAX_PAGE'])) { die(); }
?>
<?php if($pageCount>1): ?>
	<div class="row load-more">
		<div class="col-lg-12"><a href="#" class="product-load-more-btn font-fix"><?=GetMessage("loadmore");?></a></div>
	</div>
<?php endif; ?>
<!--RestartBuffer-->