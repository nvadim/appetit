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
		"IBLOCK_TYPE_ORDER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ORDER_IBLOCK"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_ORDER" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ORDER_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"IBLOCK_TYPE_PAY_METHOD" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_PAYSYS_IBLOCK"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_PAY_METHOD" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_PAYSYS_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"IBLOCK_TYPE_EXTRA_ITEM" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_EXTRA_ITEM_IBLOCK"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_EXTRA_ITEM" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_EXTRA_ITEM_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"IBLOCK_TYPE_DESTRICT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_DESTRICT_IBLOCK"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID_DESTRICT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_DESTRICT_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"SHOP_MIN_SUMM" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_SHOP_MIN_SUMM"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"PAY_ON" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_PAY_ON"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => 'N',
		),
		"PAY_TEST_MODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_PAY_TEST_MODE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => 'N',
		),
		"ROBOKASSA_IDENT" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ROBOKASSA_IDENT"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"ROBOKASSA_PASS_1" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ROBOKASSA_PASS_1"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"ROBOKASSA_PASS_2" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("BD_PARAM_ROBOKASSA_PASS_2"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
	)
);
?>