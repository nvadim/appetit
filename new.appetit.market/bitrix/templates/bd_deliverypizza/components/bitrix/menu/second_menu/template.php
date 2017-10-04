<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (!empty($arResult)):?>
<nav>
<ul>
<?
$url = explode('/',$_SERVER['REQUEST_URI']);

$previousLevel = 0;
foreach($arResult as $arItem):?>

<?if ($arItem["DEPTH_LEVEL"] == 1):?>
<?else:?>
		<?php if(
	(substr_count($arItem["LINK"],$url[3])>0 && '/'.$url[1].'/' == SITE_DIR)|| 
	(substr_count($arItem["LINK"],$url[2]) >0 && SITE_DIR == '/')

				): ?>
			<li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
		<?endif?>
<?endif?>

<?endforeach?>
</ul>
</nav>
<?endif?>