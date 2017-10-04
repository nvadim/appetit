<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$props = array();
if(!empty($arResult['PROPERTIES']['BD_PROPS_1']['VALUE'])){
	foreach ($arResult['PROPERTIES']['BD_PROPS_1']['VALUE'] as $prop_item){
		if(!empty($prop_item['VALUE']))
			$props[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
	}
}
if(!empty($arResult['PROPERTIES']['BD_PROPS_2']['VALUE'])){
	foreach ($arResult['PROPERTIES']['BD_PROPS_2']['VALUE'] as $prop_item){
		if(!empty($prop_item['VALUE']))
			$props[$prop_item['PROP']][] = array('VALUE'=>$prop_item['VALUE'],'PRICE'=>$prop_item['PRICE'],'OLD_PRICE'=>$prop_item['OLD_PRICE'],'WEIGHT'=>$prop_item['WEIGHT']);
	}
}

$arResult['PROPS'] = $props;

if(!empty($arResult['PROPERTIES']['BADGES'])){
	$arNames = Array();
	$ShopOption = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("ID"=>$arResult['PROPERTIES']['BADGES']["VALUE"]), false, false, Array("ID", "NAME", "PROPERTY_COLOR", "PROPERTY_ICON"));

	while($arShopOption = $ShopOption->GetNext()){
		$arResult["BADGES"][] = array(
			"ID" => $arShopOption['ID'],
			"NAME" => $arShopOption['NAME'],
			"COLOR" => $arShopOption['PROPERTY_COLOR_VALUE'],
			"ICON" => CFile::GetPath($arShopOption['PROPERTY_ICON_VALUE'])
		);
	}
}

$_SESSION['WATCHED'][$arResult['ID']] = $arResult['ID'];