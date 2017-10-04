<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
{
    ShowError("Модуль iblock не подключен");
    return;
}

if(!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 36000000;

$arResult["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arResult["ITEMS"] = array();

if ($this->StartResultCache())
{
    $rsElments = CIBlockElement::GetList(
        array(
            "PROPERTY_DATE" => "DESC",
            "ID" => "DESC"
        ),
        array(
            "IBLOCK_ID" => $arResult["IBLOCK_ID"],
            "ACTIVE" => "Y",
            "ACTIVE_DATE" => "Y"
        ),
        false,
        array("nPageSize" => 1),
        array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_URL")
    );

    if ($arElement = $rsElments->GetNext())
    {
        $arElement["DETAIL_PICTURE_SRC"] = CFile::GetPath($arElement["DETAIL_PICTURE"]);
        $arResult = $arElement;
    }


    $this->IncludeComponentTemplate();
}
?>