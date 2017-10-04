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
$this->setFrameMode(true);
	 $arResult["OLD_PRICE"] = $arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"];
	 $arResult["PRICE"] = $arResult["PROPERTIES"]["PRICE"]["VALUE"];	
	 $arResult["G"] = $arResult["PROPERTIES"]["G"]["VALUE"];
	 $arResult["G_UNITS"] = $arResult["PROPERTIES"]["UNITS"]["VALUE"];
?>
 <div class="status-bar"><a href="<?php echo $arResult['SECTION']['SECTION_PAGE_URL']; ?>" class="back"></a>
     <div class="title"><?=$arResult["NAME"]?></div>
        </div>
        <div class="product-detail-cont">
	        <div class="col-lg-3 col-xl-3 col-sm-6  product-detail">
		        <div data-id="<?=$arResult['ID'];?>" itemscope itemtype="http://schema.org/Product" class="product" id="<?=$this->GetEditAreaId($arResult['ID']);?>"  data-unit="<?php echo $arResult['PROPERTIES']['UNITS']['VALUE']; ?>">
			        <div data-modal="product-detail" class="preview md-trigger">
				        <?if($arResult["PROPERTIES"]['BADGES']["VALUE"]):?>
					        <div class="product-labels">
						        <?foreach ($arResult["BADGES"] as $key=>$Badges) :?>
							        <div title="<?=$Badges['NAME']?>" class="product-label"><img src="<?=$Badges['ICON']?>"></div>
						        <?endforeach?>
					        </div>
				        <?endif;?>

				        <?if($arResult['PREVIEW_PICTURE']):?>
					        <?
					        $MiniPhoto = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width'=>'400', 'height'=>'400'), BX_RESIZE_IMAGE_EXACT, true);

					        ?>
					        <picture>
						        <a itemprop="image" href="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" onclick="return false;">
							        <img
								        src="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>"
								        alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>"
								        title="<?=$arResult["PREVIEW_PICTURE"]["TITLE"]?>"
								        class="product-image"
							        />
						        </a>
					        </picture>

				        <?else:?>
					        <img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo.jpg" itemprop="image" class="product-image">
				        <?endif;?>

				        <div class="overlay">
					        <div class="zoom-btn"></div>
				        </div>
				        <?php if($arResult['PROPERTIES']['NO_SALE']['VALUE']=='Y'):?><div title="<?=GetMessage("item_no_sale_title");?>" class="without-sale"></div><?php endif; ?>
				        <?Bd\Deliverypizza\UncachedArea::startCapture();?>
				        <div class="likes">
					        <div class="like-content">
						        <div class="like-icon"></div><span>#LIKES#</span>
					        </div>
				        </div>
				        <?$like_native = Bd\Deliverypizza\UncachedArea::endCapture();?>
				        <?Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $arResult, 'like_native'=>$like_native));?>
			        </div>
			        <div class="product-info"><a href="<?=$arResult["DETAIL_PAGE_URL"]?>" class="product-title font-fix"><span itemprop="name"><?=$arResult["NAME"]?></span></a>
				        <div itemprop="description" class="product-description">
					        <?=$arResult["PREVIEW_TEXT"]?>
				        </div>
				        <div class="product-options">
					        <?php  foreach($arResult['PROPS'] as $key=>$props): ?>
						        <div class="options-row-select col-xl-<?php echo 12/count($arResult['PROPS']); ?> col-lg-12 options-length-<?php echo count($arResult['PROPS']); ?>">
							        <select class="prop_">
								        <option value="null"><?php echo $key; ?></option>
								        <?php foreach($props as $j=>$val): ?>
									        <option value="<?php echo $j; ?>" data-price="<?php echo $val['PRICE']; ?>" data-old-price="<?php echo $val['OLD_PRICE']; ?>" data-weight="<?php echo $val['WEIGHT']; ?>"><?php echo $val['VALUE']; ?></option>
								        <?php endforeach; ?>
							        </select>
						        </div>
					        <?php endforeach; ?>
				        </div>
                        <? $haveOldPrice = $arResult['MIN_PRICE']['VALUE'] != $arResult['MIN_PRICE']['DISCOUNT_VALUE'];?>
				        <div class="product-footer<?if($haveOldPrice):?><?else:?> base-price<?endif;?>">
					        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="product-prices font-fix">

	                  <span class="old-price" <?if(!$haveOldPrice):?>style="display: none;" <?endif;?>>
	                  	<span class="line-through"><?=number_format($arResult['MIN_PRICE']['VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  </span>
						        <span class="current-price"><span itemprop="price"><?=number_format($arResult['MIN_PRICE']['DISCOUNT_VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  <span itemprop="priceCurrency" class="text-hide"><?=CURRENCY_CODE?></span>
	                  </span>

						        <span class="weight" <?if(!$arResult["G"]):?> style="display: none;"<?endif;?>><span><?=$arResult["G"]?></span><span> <?=$arResult["G_UNITS"]?></span></span>

					        </div>
					        <div class="product-actions <?php if(intval($arResult['PROPERTIES']['BUY_IT']['VALUE'])!==0 && $arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if(  intval($arResult['PROPERTIES']['BUY_IT']['VALUE'])!==0 && (intval($arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] )== 0 || intval($arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE']) < 0)): ?>progress-complete<?php endif; ?>">
						        <?php
						        $delta = Bd\Deliverypizza\Models\Product::GetProductDelta($arResult['ID']);
						        if($delta<0) $delta = 0; ?>
						        <?php if(!empty($arResult['PROPERTIES']['BUY_IT']['VALUE'])): ?>
							        <?Bd\Deliverypizza\UncachedArea::startCapture();?>
							        <div class="progress-container">
								        <div style="width: #PERCENT#%;" class="progress-bar"></div>
								        <div class="progress-bar-content font-fix">
									        <div>#PLURAL#</div>
								        </div>
							        </div>
							        <?$delta_ = Bd\Deliverypizza\UncachedArea::endCapture();?>
							        <?Bd\Deliverypizza\UncachedArea::show('productDelta', array('id' => $arResult['ID'],'dc'=>$delta_));?>
						        <?php endif;?>
						        <?Bd\Deliverypizza\UncachedArea::startCapture();?>
						        <a <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arResult['ID']; ?>" href="#" class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
						        <?$buy = Bd\Deliverypizza\UncachedArea::endCapture();?>

						        <?Bd\Deliverypizza\UncachedArea::startCapture();?>
						        <a <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arResult['ID']; ?>" href="#" class="add-to-cart-btn native retry"><?=GetMessage("one_more_add_button");?></a>
						        <?$inBasket = Bd\Deliverypizza\UncachedArea::endCapture();?>
						        <?Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $arResult['ID'], 'buy' => $buy,'inBasket'=>$inBasket));?>
					        </div>
				        </div>
			        </div>
		        </div>
	        </div>
</div>