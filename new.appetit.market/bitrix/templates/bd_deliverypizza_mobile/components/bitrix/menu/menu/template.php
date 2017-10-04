<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <nav id="menu">
      <ul>
	      <? if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'): ?><?else:?><li><a href="<?=SITE_DIR?>"><?=GetMessage('INDEX_LINK_TEXT')?></a></li><?endif?>
	      <?

foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
		continue;
?>
        <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
        <?endforeach?>
      </ul>
    </nav>
<?endif?>

