<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="accordion font-fix">
	<?foreach($arResult["ITEMS"] as $arItem):?>
				<div class="accordion__item close">
					<a href="#" class="accordion__item__head">
						<span class="accordion__item__head__text footer-h"><?echo $arItem["NAME"]?></span>
					</a>
					<div class="accordion__item__body">
						<?
			   	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			   	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			   ?>
						<div class="accordion__menu">
							<?echo $arItem["PREVIEW_TEXT"];?>
						</div>
					</div><!--accordion__item__body-->
				</div><!--accordion__item-->
	<?endforeach;?>
			</div>