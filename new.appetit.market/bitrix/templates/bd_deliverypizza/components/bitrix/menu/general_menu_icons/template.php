<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <ul class="font-fix menu-general-icons clearfix">
      <?
      foreach($arResult as $arItem):
      	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
      		continue;
      ?>
      <?if($arItem["SELECTED"]):?>
        <li class="active" style="background-image: url(<?=$arItem["PARAMS"]["UF_ICON"]?>)">
          <a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span></a>
        </li>
      <?else:?>
        <li style="background-image: url(<?=$arItem["PARAMS"]["UF_ICON"]?>)"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
      <?endif?>
       <?endforeach?>
    </ul>
<?endif?>