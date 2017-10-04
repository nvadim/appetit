<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/constructor.php");
CModule::IncludeModule('iblock');

$base = array();
$souse = array();
$presets = array();
$filling = array();
$filling_categories = array();

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_PRICE","PROPERTY_WEIGHT",'PROPERTY_INGREDIENTS');
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_BOX"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>999), $arSelect);
while($ob = $res->GetNextElement())
{
	$tmp_ar = $ob->GetFields();
	$tmp_ar['PROPS'] =  $ob->GetProperties();
	$tmp_ar['price_s'] = 0;
	$tmp_ar['weight_s'] = 0;
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_PRICE","PROPERTY_GRAMM");
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_INGREDIENTS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","ID"=>$tmp_ar['PROPS']['INGREDIENTS']['VALUE']);
	$res_ = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>999), $arSelect);
	while($ob_ = $res_->GetNextElement())
	{
		$tmp_ar_ = $ob_->GetFields();
		$tmp_ar['price_s'] += $tmp_ar_['PROPERTY_PRICE_VALUE'];
		$tmp_ar['weight_s'] += $tmp_ar_['PROPERTY_GRAMM_VALUE'];;
	}


	$tmp_ar['image'] =  CFile::ResizeImageGet($tmp_ar["PREVIEW_PICTURE"], Array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_EXACT, true);
	$tmp_ar['big_image'] =  CFile::ResizeImageGet($tmp_ar["PREVIEW_PICTURE"], Array('width'=>351, 'height'=>351), BX_RESIZE_IMAGE_EXACT, true);
	$presets[$tmp_ar['ID']] = $tmp_ar;
}

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE","PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_BASE"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=> "ASC"), $arFilter, false, Array("nPageSize"=>999), $arSelect);
while($ob = $res->GetNextElement())
{
	$tmp_ar = $ob->GetFields();
	$tmp_ar['image'] =  CFile::ResizeImageGet($tmp_ar["PREVIEW_PICTURE"], Array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
	$base[] = $tmp_ar;
}

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_SOUS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=> "ASC"), $arFilter, false, Array("nPageSize"=>999), $arSelect);
while($ob = $res->GetNextElement())
{
	$tmp_ar = $ob->GetFields();
	$tmp_ar['image'] =  CFile::ResizeImageGet($tmp_ar["PREVIEW_PICTURE"], Array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_EXACT, true);
	$souse[] = $tmp_ar;
}

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "IBLOCK_SECTION_ID");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_INGREDIENTS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>999), $arSelect);
while($ob = $res->GetNextElement())
{
	$tmp_ar = $ob->GetFields();
	$filling[] = $tmp_ar;
}
$arSelect = Array("ID",  "NAME");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID_INGREDIENTS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect);
while($ob = $res->GetNext())
{
	$tmp_ar = $ob;
	$filling_categories[] = $tmp_ar;
}

$arResult['BASE'] = $base;
$arResult['SOUSE'] = $souse;
$arResult['FILLING'] = $filling;
$arResult['PRESETS'] = $presets;
$arResult['FILLING_CATS'] = $filling_categories;

$this->IncludeComponentTemplate();
?>

