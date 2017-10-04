<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="gifts-list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
          <div class="gift-item <?php if(isset($_SESSION['GIFT_ID']) && $_SESSION['GIFT_ID']!=$arItem['ID']):  ?>masked<?php endif; ?> <?php if(isset($_SESSION['GIFT_ID']) && $_SESSION['GIFT_ID']==$arItem['ID']): ?>active<?php endif; ?>" data-id="<?php echo $arItem['ID']; ?>" data-limit="<?php echo $arItem["STICKER_GIFT"]['ORDER_FROM']; ?>">
	          <div class="mask"></div>
            <div class="gift-image">
              <div class="image">
	              <?$MiniPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>'127', 'height'=>'100'), BX_RESIZE_IMAGE_EXACT, true);?>
	              	<img
			                  src="<?=CUtil::GetAdditionalFileURL($MiniPhoto['src']);?>"
			                  alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			                  title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			                  itemprop="image"
		            />
              </div>
            </div>
            <div class="gift-description">
              <div class="name"><?echo $arItem["NAME"]?></div>
              <div class="description"><?echo $arItem["PREVIEW_TEXT"];?></div>
	            <?php if(isset($_SESSION['GIFT_ID']) && $_SESSION['GIFT_ID']!=$arItem['ID'] || !isset($_SESSION['GIFT_ID'])): ?>
	            <button type="button" class="get-gift" <?php if($_SESSION['BASKET_SUM_GIFT']<$arItem["STICKER_GIFT"]['ORDER_FROM']): ?>style="display: none;" <?php endif; ?>><?=GetMessage("choise_gift");?></button>
	            <?php else: ?>
		            <button type="button" class="get-gift get-another-gift" <?php if($_SESSION['BASKET_SUM_GIFT']<$arItem["STICKER_GIFT"]['ORDER_FROM']): ?>style="display: none;" <?php endif; ?>><?php echo GetMessage("another_gift"); ?></button>
	            <?php endif; ?>

	            <div class="gift-progress-info" data-limit="<?php echo $arItem["STICKER_GIFT"]['ORDER_FROM']; ?>" <?php if($_SESSION['BASKET_SUM_GIFT']>=$arItem["STICKER_GIFT"]['ORDER_FROM']): ?>style="display: none;" <?php endif; ?>>
              <div class="progress-container">
                <div style="width: <?php echo $_SESSION['BASKET_SUM']/$arItem["STICKER_GIFT"]['ORDER_FROM']*100; ?>%;" class="progress-bar"></div>
                <div class="progress-bar-content font-fix">
                  <div><?php echo GetMessage("gift_desc"); ?> <span><?php echo number_format($arItem["STICKER_GIFT"]['ORDER_FROM']-$_SESSION['BASKET_SUM_GIFT'],0,'.',' '); ?> </span><span class="currency"><?=CURRENCY_FONT;?></span></div>
                </div>
              </div>
		       </div>
            </div>
          </div>
    <?endforeach;?>      
        </div>