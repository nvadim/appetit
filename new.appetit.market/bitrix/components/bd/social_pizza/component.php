<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$arResult['SOCIAL'] = array();

$vk = \COption::GetOptionString('bd.deliverypizza','BD_SOCIAL_VK', '', SITE_ID);
if(!empty($vk)){
	$arResult['SOCIAL'][] = array('class'=>'vk','url'=>$vk);
}
$fb = \COption::GetOptionString('bd.deliverypizza','BD_SOCIAL_FB', '', SITE_ID);
if(!empty($fb)){
	$arResult['SOCIAL'][] = array('class'=>'fb','url'=>$fb);
}
$tw= \COption::GetOptionString('bd.deliverypizza','BD_SOCIAL_TW', '', SITE_ID);
if(!empty($tw)){
	$arResult['SOCIAL'][] = array('class'=>'tw','url'=>$tw);
}
$inst = \COption::GetOptionString('bd.deliverypizza','BD_SOCIAL_INST', '', SITE_ID);
if(!empty($inst)){
	$arResult['SOCIAL'][] = array('class'=>'instagram','url'=>$inst);
}
$yt = \COption::GetOptionString('bd.deliverypizza','BD_SOCIAL_YT', '', SITE_ID);
if(!empty($yt)){
	$arResult['SOCIAL'][] = array('class'=>'yt','url'=>$yt);
}
$this->IncludeComponentTemplate();
?>

