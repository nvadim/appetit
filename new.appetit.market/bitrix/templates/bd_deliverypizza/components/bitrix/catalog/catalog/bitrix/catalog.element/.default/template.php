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

<div class="row container product product-detail" itemscope itemtype="http://schema.org/Product" data-id="<?php echo $arResult['ID'];?>">
          <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 push-lg-4">
            <div class="preview">
                   <?if($arResult["PROPERTIES"]['BADGES']["VALUE"]):?>
                   		<div class="product-labels">
                        	<?foreach ($arResult["BADGES"] as $key=>$Badges) :?>
                        		<div title="<?=$Badges['NAME']?>" class="product-label"><img src="<?=$Badges['ICON']?>"></div>
						 	<?endforeach?>
						 </div>
					<?endif;?>
                   <?if($arResult['PREVIEW_PICTURE']):?>
	                   <?
	                   $MiniPhoto = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width'=>'336', 'height'=>'261'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                   $MiniPhoto2 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width'=>'379', 'height'=>'275'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                   $MiniPhoto3 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width'=>'553', 'height'=>'475'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                   $MiniPhoto4 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width'=>'480', 'height'=>'372'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	                   ?>

	                   <picture>
		                   <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto3['src']);?>" media="(max-width: 554px)">
		                   <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto2['src']);?>" media="(max-width: 768px)">
		                   <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto4['src']);?>" media="(max-width: 992px)">
		                   <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" media="(max-width: 2000px)">
		                   <a itemprop="image" href="<?=CUtil::GetAdditionalFileURL($MiniPhoto4['src']);?>" onclick="return false;">
		                   <img
			                   src="<?=CUtil::GetAdditionalFileURL($MiniPhoto4['src']);?>"
			                   alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>"
			                   title="<?=$arResult["PREVIEW_PICTURE"]["TITLE"]?>"
			                   class="product-image"
		                   />
		                   </a>
	                   </picture>
	                <?else:?>
	                    <img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo.jpg" itemprop="image" class="product-image">
	                <?endif;?>
	            <?Bd\Deliverypizza\UncachedArea::startCapture();?>
	            <div class="likes">
		            <div class="like-content">
			            <div class="like-icon"></div><span>#LIKES#</span>
		            </div>
	            </div>
	            <?$like_native = Bd\Deliverypizza\UncachedArea::endCapture();?>
	            <?Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $arResult, 'like_native'=>$like_native));?>
              <div class="icons">
                <div class="product-icon icon-hot"></div>
                <div class="product-icon icon-vegan"></div>
              </div>
            </div>
          </div>
          <div class="product-info col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 pull-lg-4">
	          <div class="hidden-xs-up" itemprop="name"><?=$arResult["NAME"]?></div>
            <div itemprop="description" class="product-description">
	            <?if($arResult['DETAIL_TEXT']):?>
				<?=$arResult["DETAIL_TEXT"]?>
				<?else:?>
				<?=$arResult["PREVIEW_TEXT"]?>
			<?php endif; ?>
            </div>
	          <?php if(!empty($arResult['PROPERTIES']['PROTEINS']['VALUE']) || !empty($arResult['PROPERTIES']['FATS']['VALUE']) || !empty($arResult['PROPERTIES']['CARBOHYDRATES']['VALUE']) || !empty($arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE'])): ?>
            <div class="product-energy"><a href="#"><?=GetMessage("item_energy_title");?></a>
              <div class="energy-value-content">
                <ul>
	                <?php if(!empty($arResult['PROPERTIES']['PROTEINS']['VALUE'])): ?>
                  <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_1");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['PROTEINS']['VALUE']; ?></span></li>
			          <?php endif; ?>
	                <?php if(!empty($arResult['PROPERTIES']['FATS']['VALUE'])): ?>
                  <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_2");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['FATS']['VALUE']; ?></span></li>
	                <?php endif; ?>
	                <?php if(!empty($arResult['PROPERTIES']['CARBOHYDRATES']['VALUE'])): ?>
                  <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_3");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['CARBOHYDRATES']['VALUE']; ?></span></li>
	                <?php endif; ?>
	                <?php if(!empty($arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE'])): ?>
                  <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_4");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE']; ?></span></li>
	                <?php endif; ?>
                </ul>
              </div>
            </div>
            <?php endif; ?>
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
              <div class="clearfix"></div>
            </div>
              <? $haveOldPrice = $arResult['MIN_PRICE']['VALUE'] != $arResult['MIN_PRICE']['DISCOUNT_VALUE'];?>
	          <div class="<?if($haveOldPrice):?><?else:?> base-price<?endif;?>">
	          <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="product-prices font-fix">
	                  <span class="old-price" <?if(!$haveOldPrice):?>style="display: none;" <?endif;?>>
	                  	<span class="line-through"><?=number_format($arResult['MIN_PRICE']['VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  </span>
		          <span class="current-price"><span itemprop="price"><?=number_format($arResult['MIN_PRICE']['DISCOUNT_VALUE'],0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  <span itemprop="priceCurrency" class="text-hide"><?=CURRENCY_CODE; ?></span>
	                  </span>

		          <span class="weight" <?if(!$arResult["G"]):?> style="display: none;"<?endif;?>><span><?=$arResult["G"]?></span><span> <?=$arResult["G_UNITS"]?></span></span>
		          <?php if($arResult['PROPERTIES']['NO_SALE']['VALUE']=='Y'):?><div title="<?=GetMessage("item_no_sale_title");?>" class="without-sale"></div><?php endif; ?>
	          </div>
	          </div>
            <div class="product-actions <?php if(intval($arResult['PROPERTIES']['BUY_IT']['VALUE'])!==0 && $arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if(intval($arResult['PROPERTIES']['BUY_IT']['VALUE'])!==0 &&  $arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] <= 0): ?>progress-complete<?php endif; ?>">


	            <?php $delta = $arResult['PROPERTIES']['BUY_IT']['VALUE']-$arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE']; if($delta<0) $delta = 0; ?>
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
	            <a  <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arResult['ID']; ?>" href="#" class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
	            <?$buy = Bd\Deliverypizza\UncachedArea::endCapture();?>

	            <?Bd\Deliverypizza\UncachedArea::startCapture();?>
	            <a <?php if($delta>0): ?>data-max="<?=intval($delta);?>"<?php endif; ?> data-id="<?php echo $arResult['ID']; ?>" href="#" class="add-to-cart-btn native retry"><?=GetMessage("one_more_add_button");?></a>
	            <?$inBasket = Bd\Deliverypizza\UncachedArea::endCapture();?>
	            <?Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $arResult['ID'], 'buy' => $buy,'inBasket'=>$inBasket));?>
            </div>
            <div class="back-to-catalog font-fix"><a href="<?php echo $arResult['SECTION']['SECTION_PAGE_URL']; ?>"><span class="go-back"><?=GetMessage("go_back");?></span></a></div>
          </div>
</div>

