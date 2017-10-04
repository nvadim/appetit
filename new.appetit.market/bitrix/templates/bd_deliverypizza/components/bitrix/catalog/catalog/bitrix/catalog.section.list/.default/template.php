<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>

<?php
if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<div class="row">
	<?php if(COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_CONSTRUCTOR', '', SITE_ID) == 'Y'): ?>
	<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 category-view-item">
		<div class="col-xs-5 category-view-image">
			<img src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-category.png');?>"  height="82" alt="<?=GetMessage("WOK_BOX");?>" title="<?=GetMessage("WOK_BOX");?>"
					/>
		</div>
		<div class="col-xs-7 category-view-name">
			<div class="name-cont">
				<a href="<?SITE_DIR?>/catalog/constructor/"><?=GetMessage("WOK_BOX");?></a>
			</div>
		</div>
		<div class="col-xs-12 category-view-description"><?=GetMessage("WOK_BOX_DESC");?></div>
	</div>
	<?php endif; ?>
	<?php foreach ($arResult['SECTIONS'] as &$arSection):?>
		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 category-view-item">
			<?php
				$arFilter = Array("IBLOCK_ID"=>$arSection['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",'SECTION_ID'=>$arSection['ID']);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
				while($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					$last_product = $arFields;
				}
				$img =  CFile::ResizeImageGet($last_product['PREVIEW_PICTURE'], array('width'=>'160', 'height'=>'125'), BX_RESIZE_IMAGE_EXACT, true);
				$img2 =  CFile::ResizeImageGet($last_product['PREVIEW_PICTURE'], array('width'=>'190', 'height'=>'150'), BX_RESIZE_IMAGE_EXACT, true);
				$img3 =  CFile::ResizeImageGet($last_product['PREVIEW_PICTURE'], array('width'=>'250', 'height'=>'200'), BX_RESIZE_IMAGE_EXACT, true);
				$sub_categories = array();
				$rsParentSection = CIBlockSection::GetByID($arSection['ID']);
				if ($arParentSection = $rsParentSection->GetNext())
				{
					$arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
					$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
					while ($arSect = $rsSect->GetNext())
					{
						$sub_categories[] = $arSect;
					}
				}
				if(!empty($arSection['PICTURE'])){
					$img =  CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>'160', 'height'=>'125'), BX_RESIZE_IMAGE_EXACT, true);
					$img2 =  CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>'190', 'height'=>'150'), BX_RESIZE_IMAGE_EXACT, true);
					$img3 =  CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>'250', 'height'=>'200'), BX_RESIZE_IMAGE_EXACT, true);
				}
			?>
			<div class="col-xs-5 category-view-image">
				<picture>
					<source srcset="<?=CUtil::GetAdditionalFileURL($img2['src']);?>" media="(max-width: 768px)">
					<source srcset="<?=CUtil::GetAdditionalFileURL($img2['src']);?>" media="(max-width: 554px)">
					<source srcset="<?=CUtil::GetAdditionalFileURL($img['src'])?>" media="(max-width: 992px)">
					<source srcset="<?=CUtil::GetAdditionalFileURL($img['src'])?>" media="(max-width: 2000px)">
					<img src="<?=CUtil::GetAdditionalFileURL($img3['src'])?>"  alt="<?=$last_product["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$last_product["PREVIEW_PICTURE"]["TITLE"]?>"
					/>
				</picture>
			</div>
			<div class="col-xs-7 category-view-name">
				<div class="name-cont">
					<a href="<?php echo $arSection['SECTION_PAGE_URL']; ?>"><?php echo $arSection['NAME']; ?></a>
				</div>
				<?php if(!empty($sub_categories)): ?>
					<ul class="sub-categories">
					<?php foreach($sub_categories as $sc): ?>
						<li><a href="<?php echo $arSection['SECTION_PAGE_URL'].'/'.$sc['CODE'].'/'; ?>"><?php echo $sc['NAME']; ?></a></li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php } ?>
