<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CModule::IncludeModule("iblock"))
	return;
	
if(isset($_POST['action']) && $_POST['action']=='addMember'){
	$arParams = unserialize(base64_decode($_POST['ajax_params']));
	$rs__ = CIBlockElement::GetList (
	   Array("RAND" => "ASC"),
	   Array("IBLOCK_ID" => $arParams['IBLOCK_ID_VK_USER'],'PROPERTY_REPOST_RELATION'=>$_POST['element_id'],'PROPERTY_REPOST_FIO'=>iconv('utf-8',LANG_CHARSET,$_POST['name'])),
	   false,
	   false,
	   array('ID')
	);
	if($rs__->SelectedRowsCount()==0){
		$el = new CIBlockElement;
	
		$PROP = array();
		$PROP['REPOST_RELATION'] = $_POST['element_id'];
		$PROP['REPOST_FIO'] = iconv('utf-8',LANG_CHARSET,$_POST['name']);
		$PROP['REPOST_URL'] = $_POST['url'];
		$PROP['ID_USER'] = $_POST['vk_id'];
		$PROP['REPOST_PHOTO'] = $_POST['photo_url'];
		$PROP['ID_POST'] = $_POST['post_id'];
		
		$arLoadProductArray = Array(
		  "IBLOCK_SECTION_ID" => false,
		  "IBLOCK_ID"      => $arParams['IBLOCK_ID_VK_USER'],
		  "PROPERTY_VALUES"=> $PROP,
		  "NAME"           => iconv('utf-8',LANG_CHARSET,$_POST['name']),
		  "ACTIVE"         => "Y"
		  );
		
		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		  echo "New ID: ".$PRODUCT_ID;
		else
		  echo "Error: ".$el->LAST_ERROR;
	}
	exit;
}
if(isset($_POST['action']) && $_POST['action']=='random'){
	include 'VK/VK.php';
	include 'VK/VKException.php';
	$arParams = unserialize(base64_decode($_POST['ajax_params']));
	$vk_config = array(
	    'app_id'        => $arParams['APP_ID_VK'],
	    'api_secret'    => $arParams['APP_SECRET_VK'],
	    'callback_url'  => $arParams['APP_CALLBACK_URL_VK'],
	    'api_settings'  => 'wall'
	);
	
	$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);
	
	$rs = CIBlockElement::GetList (
	   Array("RAND" => "ASC"),
	   Array("IBLOCK_ID" => $arParams['IBLOCK_ID_VK_USER'],'PROPERTY_REPOST_RELATION'=>$_POST['element_id']),
	   false,
	   false,
	   array('ID','PROPERTY_REPOST_RELATION','PROPERTY_REPOST_FIO','PROPERTY_REPOST_URL','PROPERTY_REPOST_PHOTO','PROPERTY_ID_POST','PROPERTY_ID_USER')
	);
	$i = 0;
	while($ob = $rs->GetNextElement()){ 
		$arFields = $ob->GetFields();  
		$post_exist = $vk->api('wall.getById', array('posts'=>$arFields['PROPERTY_ID_USER_VALUE'].'_'.$arFields['PROPERTY_ID_POST_VALUE']));
		$i++;
		if(count($post_exist['response'])>0)
			break;		 
	}
	
	CIBlockElement::SetPropertyValues($_POST['element_id'], $arParams['IBLOCK_ID_VK_REPOST'], $arFields['ID'], 'WINNER_SUP');
	CIBlockElement::SetPropertyValues($_POST['element_id'], $arParams['IBLOCK_ID_VK_REPOST'], $i, 'NO_WINNER');
	
	echo json_encode($arFields);
	exit;
}		