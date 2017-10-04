<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
 <div class="status-bar detail-shadow"><a href="<?php echo $arResult['LIST_PAGE_URL']; ?>" class="back"></a>
          <div class="title" itemprop="headline name"><?php echo $arResult['NAME']; ?></div>
        </div>
        <div class="news-list">
          <article class="news-item with-photo">
            <div class="news-content">
	           <div class="news-date" itemprop="datePublished" content="<?php echo date('Y-m-d',strtotime($arItem["PROPERTIES"]['DATE']["VALUE"])); ?>"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
              <div class="news-text" itemprop="articleBody">
<?=$arResult["DETAIL_TEXT"];?>
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

						<img src="<?=CUtil::GetAdditionalFileURL($photo['src']);?>" alt="">
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
            </div>
          </article>
        </div>