<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
$basket_m = new Deliverypizza\Models\Basket();
$basket = $basket_m->getBasket(0,session_id(),false);
$basket_res = unserialize($basket['BASKET_CONTENT']);
foreach($arResult["ITEMS"] as $key=>$arItem):?>

<?
	$arItem['IN_BASKET'] = 0;
	foreach($basket_res as $bi){
		if($bi['PRODUCT_ID']==$arItem['ID'])
			$arItem['IN_BASKET'] = 1;
	}
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
	}}

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

	$arItem['PROPS'] = $props;
	$arResult['ITEMS'][$key]= $arItem;
?>
<?endforeach;?>