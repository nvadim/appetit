<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

                <ul class="font-fix menu-general">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
<?if($arItem["SELECTED"]):?>
                  <li class="active"><a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span></a></li>
<?else:?>
                  <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
<?endif?>
 <?endforeach?>    
 <li class="menu-extend-cont"><a href="#" data-id="menu-extend" data-handler="popover" class="menu-more-btn"><?=GetMessage("more");?></a></li>
 </ul>           
                <div id="menu-extend" class="bd-popup">
                  <nav>
                    <ul class="popover-nav menu-extended">

                    </ul>
                  </nav>
                </div>
                
              
<?endif?>