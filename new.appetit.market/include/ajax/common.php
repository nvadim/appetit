<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bd\Deliverypizza;
use \Bitrix\Main\Loader;

Loader::includeModule('sale');
Loader::includeModule('catalog');

if(isset($_GET['action']) && $_GET['action']=='getDetail'){

    Loader::includeModule('iblock');

    $props = array();

    $base = CIBlockElement::GetByID($_POST['PRODUCT_ID'])->GetNext();
    $db_props = CIBlockElement::GetProperty(\Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_content_pizza"]["bd_catalog"][0], $_POST['PRODUCT_ID'], array("sort" => "asc"), Array());
    while($ar_props = $db_props->GetNext()){
        if($ar_props['CODE'] == 'BADGES'){
            if(!empty($ar_props['VALUE']))
                $props[$ar_props['CODE']][] = $ar_props['VALUE'];
        }else{
            $props[$ar_props['CODE']] = $ar_props['VALUE'];
        }

        if($ar_props['CODE'] == 'UNITS')
        {
            $props[$ar_props['CODE']] = (!empty($ar_props['VALUE_ENUM'])) ?  $ar_props['VALUE_ENUM']: '';
        }
    }

    $result = array();
    $result['BADGES'] = array();
    if(!empty($props['BADGES'])){
        $arNames = Array();
        $ShopOption = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("ID"=>$props['BADGES']), false, false, Array("ID", "NAME", "PROPERTY_COLOR", "PROPERTY_ICON"));

        while($arShopOption = $ShopOption->GetNext()){
            $result["BADGES"][] = array(
                "ID" => $arShopOption['ID'],
                "NAME" => $arShopOption['NAME'],
                "COLOR" => $arShopOption['PROPERTY_COLOR_VALUE'],
                "ICON" => CFile::GetPath($arShopOption['PROPERTY_ICON_VALUE'])
            );
        }
    }

    $result['ID'] = $base['ID'];
    $result['NAME'] = $base['NAME'];
    $result['PREVIEW_TEXT'] = $base['PREVIEW_TEXT'];
    $result['DETAIL_TEXT'] = $base['DETAIL_TEXT'];
    $result['NO_SALE'] = '';
    if($base['PREVIEW_PICTURE'])
        $result['PREVIEW_PICTURE'] = \CFile::ResizeImageGet($base['PREVIEW_PICTURE'], array('width'=>'362', 'height'=>'278'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    else
        $result['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH.'/images/no_photo.jpg';

    $result['PREVIEW_PICTURE']['SRC'] = \CUtil::GetAdditionalFileURL($result['PREVIEW_PICTURE']['src']);
    $arPrice = \CCatalogProduct::GetOptimalPrice($base['ID']);
    if ($arPrice['RESULT_PRICE']['DISCOUNT_PRICE'] != $arPrice['RESULT_PRICE']['BASE_PRICE']) {
        $result['OLD_PRICE'] = $arPrice['RESULT_PRICE']['BASE_PRICE'];
    }
    $result['PRICE'] = $arPrice['RESULT_PRICE']['DISCOUNT_PRICE'];
    //$result['PRICE'] = $props['PRICE'];
    //$result['OLD_PRICE'] = $props['OLD_PRICE'];

    $result['G'] = $props['G'];
    $result['UNIT'] = $props['UNITS'];
    $result['BUY_IT'] = $props['BUY_IT'];
    $result['BUY_IT_COMPLETE'] = $props['BUY_IT_COMPLETE'];

    $props_ = array();
    if(!empty($props['BD_PROPS_1'])){
        foreach ($props['BD_PROPS_1'] as $prop_item){
            if(!empty($prop_item['VALUE']))
                $props_[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
        }
    }
    if(!empty($props['BD_PROPS_2'])){
        foreach ($props['BD_PROPS_2'] as $prop_item){
            if(!empty($prop_item['VALUE']))
                $props_[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
        }
    }
    $result['nutrients'] = array(
        'protein' => $props['PROTEINS'],
        'fats' => $props['FATS'],
        'carbo' => $props['CARBOHYDRATES'],
        'energy' => $props['CALORIFIC_VALUE'],
    );
    $result['LIKE_COUNTER'] =  $props['LIKE_COUNTER'] + Deliverypizza\Entity\LikeTable::getCount(array('PRODUCT_ID'=>$_POST['PRODUCT_ID']));
    $result['isLiked'] = intval(Deliverypizza\Entity\LikeTable::getCount(array('=PRODUCT_ID'=>$_POST['PRODUCT_ID'],'USER_ID'=>$USER->GetID())));
    $result['BD_PROPS'] = $props_;
    echo \Bitrix\Main\Web\Json::encode($result);
    exit;
}
