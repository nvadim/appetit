<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="news-list">
	   <!--RestartBuffer-->
<?
if(isset($_GET['AJAX_PAGE'])) { $APPLICATION->RestartBuffer(); }
if(!empty($arResult['ITEMS'])): ?>
 <?foreach($arResult["ITEMS"] as $arItem):?>
 	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
 <article class="news-item <?if($arItem["PREVIEW_PICTURE"]):?>with-photo<?else:?>without-photo<?endif;?>">
            <div class="news-content">
	            <?if($arItem["PREVIEW_PICTURE"]):?>
              <div class="news-photo">
	              <?if($arItem["DETAIL_TEXT"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?else:?><?endif;?>
			                    <img
							class="preview_picture"
							itemprop="image"
							border="0"
							src="<?=CUtil::GetAdditionalFileURL($arItem["PREVIEW_PICTURE"]["SRC"])?>"
							alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
							title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
							style="float:left"
							/>
					<?if($arItem["DETAIL_TEXT"]):?></a><?else:?><?endif;?></div>
              <?else:?><?endif;?>
              <div class="news-title" itemprop="headline name">
	          <?if($arItem["DETAIL_TEXT"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?else:?><?endif;?>
             	 <?echo $arItem["NAME"]?>
              <?if($arItem["DETAIL_TEXT"]):?></a><?else:?><?endif;?>
              </div>
              <div class="news-date" itemprop="datePublished" content="<?php echo date('Y-m-d',strtotime($arItem["PROPERTIES"]['DATE']["VALUE"])); ?>"><?echo $arItem["PROPERTIES"]['DATE']["VALUE"]?></div>
              <div class="news-text" itemprop="articleBody">
	              <?echo $arItem["PREVIEW_TEXT"];?>
              </div><?if($arItem["DETAIL_TEXT"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="read-more"><?= GetMessage("detail_url"); ?></a><?else:?><?endif;?>
            </div>
          </article>
<?endforeach;?>
	<?php else: ?>
	<div class="content-page page-404 font-fix empty-items">
		<div class="status-title">
			<?php if($arParams['IBLOCK_URL'] == '/news/'): ?>
				<?= GetMessage("sorry_empty_news"); ?>
			<?php else: ?>
				<?= GetMessage("sorry_empty_sales"); ?>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>	
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
                  <a class="ajax-pager-link" data-wrapper-class="news-list" href="%s"></a>
              </div>',
		$url);
}
if(isset($_GET['AJAX_PAGE'])) {  }
?>
<!--RestartBuffer-->
</div>








