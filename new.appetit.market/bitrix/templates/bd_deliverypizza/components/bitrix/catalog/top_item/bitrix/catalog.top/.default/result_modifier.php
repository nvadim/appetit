<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;

?>
<?foreach($arResult["ITEMS"] as $key=>$arItem):?>

<?


	if(!empty($arItem['PROPERTIES']['BADGES'])){
		$arNames = Array();
		$ShopOption = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("ID"=>$arItem['PROPERTIES']['BADGES']["VALUE"]), false, false, Array("ID", "NAME", "PROPERTY_COLOR", "PROPERTY_ICON"));

		while($arShopOption = $ShopOption->GetNext()){
			$arItem["BADGES"][] = array(
				"ID" => $arShopOption['ID'],
				"NAME" => $arShopOption['NAME'],
				"COLOR" => $arShopOption['PROPERTY_COLOR_VALUE'],
				"ICON" => CFile::GetPath($arShopOption['PROPERTY_ICON_VALUE'])
			);
		}
	}



	$props = array();
	if(!empty($arItem['PROPERTIES']['BD_PROPS_1']['VALUE'])){
		foreach ($arItem['PROPERTIES']['BD_PROPS_1']['VALUE'] as $prop_item){
			if(!empty($prop_item['VALUE']))
				$props[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
		}
	}
	if(!empty($arItem['PROPERTIES']['BD_PROPS_2']['VALUE'])){
		foreach ($arItem['PROPERTIES']['BD_PROPS_2']['VALUE'] as $prop_item){
			if(!empty($prop_item['VALUE']))
				$props[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
		}
	}

	$arItem['LIKE_COUNTER'] = Deliverypizza\Entity\LikeTable::getCount(array('PRODUCT_ID'=>$arItem['ID']));
	$arItem['PROPS'] = $props;
	$arResult['ITEMS'][$key]= $arItem;
?>
<?endforeach;?>