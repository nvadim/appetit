<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult["DETAIL_PICTURE_SRC"])):?>
    <div id="banner-popup">
        <?if (!empty($arResult["PROPERTY_URL_VALUE"])):?>
            <a href="<?=$arResult["PROPERTY_URL_VALUE"]?>" title="<?=$arResult["NAME"]?>"><img src="<?=$arResult["DETAIL_PICTURE_SRC"]?>" alt="<?=$arResult["NAME"]?>"></a>
        <?else:?>
            <img src="<?=$arResult["DETAIL_PICTURE_SRC"]?>" alt="<?=$arResult["NAME"]?>">
        <?endif?>
    </div>
<?endif?>