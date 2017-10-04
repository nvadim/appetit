<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (method_exists($this, 'setFrameMode')) {
	$this->setFrameMode(true);
}
$item = $arResult['repost_item'];
$rs__ = $arResult['rs'];
$app_id = $arParams["APP_ID_VK"];
$ajaxParams = serialize(array(
	'IBLOCK_ID_VK_REPOST'=>$arParams['IBLOCK_ID_VK_REPOST'],
	'IBLOCK_ID_VK_USER'=>$arParams['IBLOCK_ID_VK_USER'],
	'APP_ID_VK'=>$arParams['APP_ID_VK'],
	'APP_SECRET_VK'=>$arParams['APP_SECRET_VK'],
	'APP_CALLBACK_URL_VK'=>$arParams['APP_CALLBACK_URL_VK'],	
));?>
<script type="text/javascript">window.vk_app_id = '<?php echo $app_id; ?>';</script> 
<script type="text/javascript" src="/bitrix/components/bd/surprise.repost/js/vk.js"></script>
<? $APPLICATION->AddHeadScript('/bitrix/components/bd/surprise.repost/js/jquery.countdown.min.js'); 
   $APPLICATION->AddHeadScript('//vk.com/js/api/openapi.js');
?>

<input type="hidden" class="element_date" value="<?php echo date('Y/m/d',strtotime($item['PROPERTY_DATE_COMPLETE_VALUE'])) ?>" />
<input type="hidden" class="image_for_vk" value="<?php echo CFile::GetPath($item['PROPERTY_PHOTO_POST_VK_VALUE']); ?>" />
<input type="hidden" class="element___id" value="<?php echo $item['ID']; ?>"/>
<input type="hidden" class="text_repost" value="<?php echo $item['PREVIEW_TEXT']; ?>" />
<input type="hidden" class="url_repost" value="<?php echo $item['PROPERTY_URL_POST_VK_VALUE']; ?>" />
<input type="hidden" class="ajax_params" value='<?php echo base64_encode($ajaxParams); ?>' />

<div class="repost_wrapper <?php if(!empty($item['PROPERTY_WINNER_SUP_VALUE'])): ?>has_winner<?php endif; ?>">
	<div class="wrap">
		<div class="repost_block repost_main_block">
			<div class="repost_inner">
				<h1><?php echo $item['NAME']; ?></h1>
				<?php if(empty($item['PROPERTY_WINNER_SUP_VALUE'])): ?>
				<div class="row">
					<div class="col text"><?=GetMessage("TIME_TO_COMPLETE");?></div>
					<div class="col countdown"><div id="clock"></div></div>
				</div>
				<div class="buttons_group">
					<?php if(!isset($_COOKIE['already_repost']) || $_COOKIE['already_repost']!=$item['ID']): ?>
						<button id="login_button" onclick="VK.Auth.login(authInfo,4);"><?=GetMessage("VK_AUTH");?></button>
						<button id="post" style="display: none;" onclick="sendwallpost()"><?=GetMessage("REPOST_VK");?></button>
						<button id="already_repost" style="display: none;"><?=GetMessage("YOU_REPOST");?></button>
					<?php else: ?>
						<button id="already_repost"><?=GetMessage("YOU_REPOST");?></button>		
					<?php endif; ?>
					<? if($USER->IsAdmin()) {?><button id="random_users" onclick="randomuser()"><?=GetMessage("CHOISE_WINNER");?></button><?}?> 
				</div>
				<div class="repost_image">
					<img src="<?php echo CFile::GetPath($item["PREVIEW_PICTURE"]); ?>" />
				</div>
				<div class="vk_like">
					<div id="vk_like"></div>
					<script type="text/javascript">
					VK.Widgets.Like("vk_like", {type: "button"});
					</script>
				</div>
				<div class="right">
					<div class="members_count"><?=GetMessage("USERS");?>: <strong><?php echo $rs__->SelectedRowsCount(); ?></strong></div>
				</div>
				<?php else: ?>
				<?php
					$arSelect = Array("ID", "NAME", "PROPERTY_REPOST_FIO",'PROPERTY_REPOST_URL','PROPERTY_REPOST_PHOTO');
					$arFilter = Array("ID"=>$item['PROPERTY_WINNER_SUP_VALUE']);
					$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
					while($ob = $res->GetNextElement())
					{
					 $user = $ob->GetFields();
					 }					
				?>
				<div class="row">
					<div class="col text complete"><span class="completed_text"><?=GetMessage("VK_REPOST_COMPLETE");?></span> <span class="completed_date"><?php echo $item['PROPERTY_DATE_COMPLETE_VALUE']; ?></span></div>
					<div class="col text winner_number"><?=GetMessage("NUMBER_WINNER");?>: <?php echo $item['PROPERTY_NO_WINNER_VALUE']; ?></div>
				</div>
				<div class="winner_info">
					<h2 class="title"><?=GetMessage("CONGRAT");?>!</h2>
					<div class="winner_photo">
						<img src="<?php echo $user['PROPERTY_REPOST_PHOTO_VALUE']; ?>" alt="<?php echo $user['NAME']; ?>">
					</div>
					<div class="winner_info_panel">
						<h3><?php echo $user['NAME'] ?></h3>
						<a href="<?php echo $user['PROPERTY_REPOST_URL_VALUE'] ?>"><?php echo $user['PROPERTY_REPOST_URL_VALUE'] ?></a>
					</div> 
					
				</div>
				<div class="clear"></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="repost_right_group">
			<?php if(empty($item['PROPERTY_WINNER_SUP_VALUE'])): ?>
			<div class="repost_block repost_secondary_block">
				<?php echo $item['DETAIL_TEXT']; ?>
<?php if(empty($arParams['VK_URL'])): ?><?php else: ?><a href="<?php echo $arParams['VK_URL']?>" target="_blank"><button class="vk_button"><span><?=GetMessage("GROUP_VK_MESSAGE");?></span><span class="vk_i"></span></button></a><?php endif; ?>
			</div>
			<?php endif; ?>
			<?php  if($arParams['ACTIVE_COMMENTS']=='Y'): ?>
			<div class="repost_block vk_comments">
				<div id="vk_comments"></div>
				<script type="text/javascript">
				VK.Widgets.Comments("vk_comments", {limit: 10, width: "100%", attach: "*"});
				</script>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="clear"></div>
