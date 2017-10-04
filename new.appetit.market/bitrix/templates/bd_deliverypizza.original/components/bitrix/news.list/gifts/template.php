<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="gift-container">
<div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	?>
            <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6 col-xs-12" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-id="<?php echo $arItem['ID']; ?>">
              <div  data-id="<?php echo $arItem['ID']; ?>" class="product gift <?php if(isset($_SESSION['GIFT_ID']) && $_SESSION['GIFT_ID']==$arItem['ID']): ?>active<?php endif; ?> <?php if(isset($_SESSION['GIFT_ID']) && $_SESSION['GIFT_ID']!=$arItem['ID']): ?>masked<?php endif; ?> ">
                <div class="mask"></div>
                <div class="back-side">
                  <div class="stars"></div>
                  <div class="gift-in-basket-text font-fix">
	                  <div><?=GetMessage("gift_");?></div>
	                  <div><?=GetMessage("_in_basket");?></div>
                  </div>
                  <button class="get-another-gift-btn font-fix"><?=GetMessage("another_gift");?></button>
                </div>
                <div class="front-side">
                  <div class="preview">
	                <?
	                $MiniPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'255', 'height'=>'197'), BX_RESIZE_IMAGE_EXACT, true);
	                $MiniPhoto2 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'353', 'height'=>'275'), BX_RESIZE_IMAGE_EXACT, true);
	                $MiniPhoto3 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'553', 'height'=>'475'), BX_RESIZE_IMAGE_EXACT, true);

	                ?>
	                  <picture>
		                  <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto2['src'])?>" media="(max-width: 554px)">
		                  <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" media="(max-width: 768px)">

		                  <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" media="(max-width: 992px)">
		                  <source srcset="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>" media="(max-width: 2000px)">
		                  <img
			                  src="<?=CUtil::GetAdditionalFileURL($MiniPhoto3['src']);?>"
			                  alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			                  title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			                  itemprop="image"
			                  class="product-image"
		                  />
	                  </picture>
	              </div>
                  <div class="product-info"><span class="product-title font-fix"><?echo $arItem["NAME"]?></span>
                    <div class="product-description"><?echo $arItem["PREVIEW_TEXT"];?></div>
                  </div>
	                <div class="gift-progress-info" data-limit="<?php echo $arItem["STICKER_GIFT"]['ORDER_FROM']; ?>" <?php if($_SESSION['BASKET_SUM_GIFT']>=$arItem["STICKER_GIFT"]['ORDER_FROM']): ?>style="display: none;" <?php endif; ?>>
		                <div class="line" style="background-color: <?php echo $arItem["STICKER_GIFT"]['COLOR']; ?>;"><?=GetMessage("gift_from");?> <?php echo number_format($arItem["STICKER_GIFT"]['ORDER_FROM'],0,'.',' '); ?><span class="currency"><?=CURRENCY_FONT;?></span></div>
		                <div class="progress-container">
			                <div style="width: <?php echo $_SESSION['BASKET_SUM']/$arItem["STICKER_GIFT"]['ORDER_FROM']*100; ?>%;" class="progress-bar"></div>
			                <div class="progress-bar-content">
				                <div><?=GetMessage("gift_desc");?></div><span class="font-fix"><span class="gift-progress-value"><?php echo number_format($arItem["STICKER_GIFT"]['ORDER_FROM']-$_SESSION['BASKET_SUM_GIFT'],0,'.',' '); ?></span><span class="currency"><?=CURRENCY_FONT;?></span></span>
			                </div>
		                </div>
	                </div>
                  <button class="get-gift-btn" <?php if($_SESSION['BASKET_SUM_GIFT']<$arItem["STICKER_GIFT"]['ORDER_FROM']): ?>style="display: none;" <?php endif; ?>><?=GetMessage("choise_gift");?></button>
                </div>
              </div>
            </div>
<?endforeach;?>
          </div>
        </div>