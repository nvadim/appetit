<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="row news-list">
    <!--RestartBuffer-->
<?
if(isset($_GET['AJAX_PAGE'])) { $APPLICATION->RestartBuffer(); }
if(!empty($arResult['ITEMS'])): ?>
 <?foreach($arResult["ITEMS"] as $arItem):?>
 	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

          <article itemscope itemtype="http://schema.org/Article" class="news-item <?if($arItem["PREVIEW_PICTURE"]):?>with-photo<?else:?>without-photo<?endif;?> col-xs-12 <?php if(isset($_GET['AJAX_PAGE'])): ?>animate<?php endif; ?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="news-content">
	            <?if($arItem["PREVIEW_PICTURE"]):?>
	                <div class="col-xl-5 col-lg-5 col-md-3 col-sm-3 col-xs-3 news-photo">
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
							<?if($arItem["DETAIL_TEXT"]):?></a><?else:?><?endif;?>
		              </div>
	              <?endif;?>
	              <?if($arItem["PREVIEW_PICTURE"]):?>
	              	<div class="col-xl-7 col-lg-7 col-md-9 col-sm-9 col-xs-9 news-text">
	              <?else:?>
	              	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
				  <?endif;?>
                <div class="news-title">
	                <?if($arItem["DETAIL_TEXT"]):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?else:?><?endif;?>
	                <span itemprop="headline name"><?echo $arItem["NAME"]?></span>
	                <?if($arItem["DETAIL_TEXT"]):?></a><?else:?><?endif;?>
	                </div>
                <div class="news-date" itemprop="datePublished" content="<?php echo date('Y-m-d',strtotime($arItem["PROPERTIES"]['DATE']["VALUE"])); ?>"><?echo $arItem["PROPERTIES"]['DATE']["VALUE"]?></div>
                <div class="news-text" itemprop="articleBody"><?echo $arItem["PREVIEW_TEXT"];?></div>
              </div>
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