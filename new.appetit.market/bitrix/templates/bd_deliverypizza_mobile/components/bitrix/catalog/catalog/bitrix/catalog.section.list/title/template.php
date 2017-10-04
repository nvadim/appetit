<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>
<?if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']){?>
<h1 class="font-fix"> 
	<?if (0 < $arResult["SECTIONS_COUNT"])
{?>
<? echo ($arResult['SECTION']['NAME']);?>	
<?}else{?>
<? echo ($arResult['SECTION']['PATH']['0']['NAME']);?> <?php if(isset($arResult['SECTION']['PATH']['1']['NAME'])): ?> (<? echo ($arResult['SECTION']['PATH']['1']['NAME']);?>)<?php endif; ?>
<?}?>
</h1>
<?}?>
