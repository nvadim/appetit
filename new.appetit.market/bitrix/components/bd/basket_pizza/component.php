<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/basket_ajax.php");
CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PROPERTY_DELIVERY_COST", "PROPERTY_FREE_DELIVERY", "PROPERTY_TIME_DELIVERY"); 
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_DESTRICT"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"); 
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize"=>100), $arSelect); 
while($ob = $res->GetNext())
{
$arResult["DESTRICT"][] = array(
"ID" => $ob['ID'],
"NAME" => $ob['NAME'],
"DELIVERY_PRICE" => $ob['PROPERTY_DELIVERY_COST_VALUE'],
"FREE_DELIVERY" => $ob['PROPERTY_FREE_DELIVERY_VALUE'],
"TIME_DELIVERY" => $ob['PROPERTY_TIME_DELIVERY_VALUE']
);
}

$arSelect = Array("ID", "NAME", "PROPERTY_IDENT_PAY"); 
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_PAY_METHOD"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"); 
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize"=>100), $arSelect); 
while($ob = $res->GetNext())
{
$arResult["PAYSYS"][] = array(
"ID" => $ob['ID'],
"NAME" => $ob['NAME'],
"IDENT_PAY" => $ob['PROPERTY_IDENT_PAY_VALUE']
);
}

$arResult["EXTRA_PRODUCT"] = array(); 
if ($arParams['SHOP_GIFT'] == 'Y') {
	$arSelect = Array("ID", "NAME", 'PROPERTY_EXTRA_PRICE', "PROPERTY_EXTRA_PHOTO");
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_EXTRA_ITEM"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
	  $arFields = $ob->GetFields();
	  $arResult["EXTRA_PRODUCT"][] = array(
		'id' => $arFields["ID"],
		'name' => $arFields["NAME"],
		'price' => $arFields["PROPERTY_EXTRA_PRICE_VALUE"],
		'photo' => CFile::GetPath($arFields['PROPERTY_EXTRA_PHOTO_VALUE'])
	  );
	}
}
$this->IncludeComponentTemplate();