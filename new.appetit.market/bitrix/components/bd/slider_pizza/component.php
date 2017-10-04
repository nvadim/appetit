<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
CModule::IncludeModule('iblock');

$arSelect = Array("ID", "NAME",'PREVIEW_PICTURE', "PROPERTY_URL", "DETAIL_PICTURE");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_SLIDER"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
$slides = array();
while($ob = $res->GetNextElement())
{
	$slides[] = $ob->GetFields();
}
$arResult['SLIDES'] = $slides;
$this->IncludeComponentTemplate();
?>

