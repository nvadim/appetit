<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
		"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
		"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
	);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_TYPE_VK_REPOST" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_VK_REPOST" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"IBLOCK_TYPE_VK_USER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_VK_USER_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_VK_USER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_VK_USER_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"APP_ID_VK" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_APP_ID_VK"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"APP_SECRET_VK" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_APP_SECRET_VK"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"APP_CALLBACK_URL_VK" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_APP_CALLBACK_URL_VK"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"VK_URL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_VK_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"ACTIVE_COMMENTS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ACTIVE_COMMENTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => 'N',
		),
	)
);
?>