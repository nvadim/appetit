<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
CModule::IncludeModule('iblock');

$arSelect = Array("ID", "NAME", "PROPERTY_ORDER_OT_GIFT", "PROPERTY_COLOR_STICKER", "PROPERTY_TECH_GIFT"); 
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_GIFTS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y"); 
$res = CIBlockElement::GetList(Array("SORT" => "DESC"), $arFilter, false, Array("nPageSize"=>3), $arSelect); 
while($ob = $res->GetNext())
{
$arResult["GIFT_BOX"][] = array(
"ID" => $ob['ID'],
"NAME" => $ob['NAME'],
"OT_GIFT" => $ob['PROPERTY_ORDER_OT_GIFT_VALUE'],
"COLOR_GIFT" => $ob['PROPERTY_COLOR_STICKER_VALUE'],
"TECH_GIFT" => $ob['PROPERTY_TECH_GIFT_VALUE']
);
}
$this->IncludeComponentTemplate();
?>

