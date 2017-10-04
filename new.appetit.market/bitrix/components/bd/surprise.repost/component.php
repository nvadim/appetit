<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); 
CModule::IncludeModule('iblock');
	$rs = CIBlockElement::GetList (
		array(),
	   Array("IBLOCK_ID" => $arParams["IBLOCK_ID_VK_REPOST"],'ACTIVE'=>'Y'),
	   false,
	   Array ("nTopCount" => 1), 
	   array('ID','PREVIEW_PICTURE','PREVIEW_TEXT','DETAIL_TEXT','NAME','PROPERTY_PHOTO_POST_VK','PROPERTY_DATE_COMPLETE','PROPERTY_WINNER_SUP','PROPERTY_LOOSER_SUP','PROPERTY_NO_WINNER','PROPERTY_URL_POST_VK')
	);
	
	while($ob = $rs->GetNextElement()){ 
	 $item = $ob->GetFields();  
	}
	
	$arResult['repost_item'] = $item;
	
	$rs__ = CIBlockElement::GetList (
	   Array("RAND" => "ASC"),
	   Array("IBLOCK_ID" => $arParams["IBLOCK_ID_VK_USER"],'PROPERTY_REPOST_RELATION'=>$item['ID']),
	   false,
	   false,
	   array('ID')
	);
	
	$arResult['rs'] = $rs__;


	
$this->IncludeComponentTemplate();

?>