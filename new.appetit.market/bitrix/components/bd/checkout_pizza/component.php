<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
global $USER;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/order.php");
unset($_SESSION['DELIVERY_PRICE']);
unset($_SESSION['FREE_DELIVERY']);
$arSelect = Array("ID", "NAME", "PROPERTY_DELIVERY_COST", "PROPERTY_FREE_DELIVERY");
$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID_DESTRICT"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize" => 100), $arSelect);
while ($ob = $res->GetNext()) {
	$arResult["DESTRICT"][] = array(
		"ID" => $ob['ID'],
		"NAME" => $ob['NAME'],
		"DELIVERY_PRICE" => $ob['PROPERTY_DELIVERY_COST_VALUE'],
		"FREE_DELIVERY" => $ob['PROPERTY_FREE_DELIVERY_VALUE']
	);
}

$arSelect = Array("ID", "NAME", "PROPERTY_IDENT",'PROPERTY_CHANGE');
$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID_PAY_METHOD"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize" => 100), $arSelect);
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_PAY_METHOD"], "CODE"=>"IDENT"));
$types = array();
while($enum_fields = $property_enums->GetNext())
{
	$types[$enum_fields["ID"]] = $enum_fields["XML_ID"];
}
while ($ob = $res->GetNext()) {

	if(COption::GetOptionString('bd.deliverypizza','BD_CF_ONLINE_PAY','',SITE_ID) == 'disabled' && $types[$ob['PROPERTY_IDENT_ENUM_ID']] == 'online')
		continue;

	$arResult["PAYSYS"][] = array(
		"ID" => $ob['ID'],
		"NAME" => $ob['NAME'],
		"IDENT_PAY" => $types[$ob['PROPERTY_IDENT_ENUM_ID']],
		"CHANGE" => $ob['PROPERTY_CHANGE_VALUE']
	);
}

$arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "PROPERTY_COORDINATE", "PROPERTY_PHONE", "PROPERTY_EMAIL");
$arFilter = Array("IBLOCK_ID" => $arParams["IBLOCK_ID_TAKE_AWAY"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array("nPageSize" => 100), $arSelect);
while ($ob = $res->GetNext()) {
	$arResult["TAKE_AWAY"][] = array(
		"ID" => $ob['ID'],
		"NAME" => $ob['NAME'],
		"COORDINATE" => $ob['PROPERTY_COORDINATE_VALUE'],
		"PHONE" => $ob['PROPERTY_PHONE_VALUE'],
		"EMAIL" => $ob['PROPERTY_EMAIL_VALUE'],
		"WORK_TIME" => $ob['PREVIEW_TEXT']
	);
}
$arResult['ADDRESSES'] = Deliverypizza\Entity\AddressTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetchAll();

if($USER->IsAuthorized()){
	$arResult['USER'] = Deliverypizza\Entity\UserTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetch();
}
$this->IncludeComponentTemplate();
?>

