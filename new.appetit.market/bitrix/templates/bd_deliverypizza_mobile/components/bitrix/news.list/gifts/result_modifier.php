<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult["ITEMS"] as $key=>$arItem):?>

<?	
if(!empty($arItem['PROPERTIES']['STICKER']['VALUE'])){
$arNames = Array();
$ShopOption = CIBlockElement::GetList (Array("SORT" => "ASC"), Array("ID"=>$arItem['PROPERTIES']['STICKER']["VALUE"]), false, false, Array("ID", "NAME", "PROPERTY_ORDER_FROM", "PROPERTY_COLOR","PROPERTY_IDENTIFIER"));
while($arShopOption = $ShopOption->GetNext()){
	$arItem["STICKER_GIFT"] = array(
		"ID" => $arShopOption['ID'],
		"NAME" => $arShopOption['NAME'],
		"ORDER_FROM" => $arShopOption['PROPERTY_ORDER_FROM_VALUE'],
		"COLOR" => $arShopOption['PROPERTY_COLOR_VALUE'],
		"IDENTIFIER" => $arShopOption['PROPERTY_IDENTIFIER_VALUE'],
	);
}}
$arResult['ITEMS'][$key]= $arItem;

?>
<?endforeach;?>