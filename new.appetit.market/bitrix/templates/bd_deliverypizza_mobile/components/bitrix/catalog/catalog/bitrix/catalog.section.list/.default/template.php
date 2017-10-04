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
<ul id="catalog-panel" class="font-fix">
	<?php if(COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_CONSTRUCTOR', '', SITE_ID) == 'Y'): ?>
	<li><a href="<?=SITE_DIR?>catalog/constructor/"><div class="category-image"><img src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-category.png');?>" alt="<?=GetMessage("WOK_BOX");?>" title="<?=GetMessage("WOK_BOX");?>"></div><span><?=GetMessage("WOK_BOX");?></span></a></li>
	<?php endif; ?>
<?php foreach ($arResult['SECTIONS'] as &$arSection):?>
<?php
				$arFilter = Array("IBLOCK_ID"=>$arSection['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",'SECTION_ID'=>$arSection['ID']);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
				while($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					$last_product = $arFields;
				}
				$img =  CFile::ResizeImageGet($last_product['PREVIEW_PICTURE'], array('width'=>'100', 'height'=>'100'), BX_RESIZE_IMAGE_EXACT, true);
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
					$img =  CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>'100', 'height'=>'100'), BX_RESIZE_IMAGE_EXACT, true);
				}
			?>
            <li>
            <a href="<?php echo $arSection['SECTION_PAGE_URL']; ?>"><div class="category-image"><img src="<?=CUtil::GetAdditionalFileURL($img['src'])?>"  alt="<?=$last_product["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$last_product["PREVIEW_PICTURE"]["TITLE"]?>"
					/></div><span><?php echo $arSection['NAME']; ?></span></a>
            <?php if(!empty($sub_categories)): ?>
	            <div class="sub-categories-toggle"></div>
                <ul class="mm-vertical">
	          <?php foreach($sub_categories as $sc): ?>
                <li><a href="<?php echo $arSection['SECTION_PAGE_URL'].'/'.$sc['CODE'].'/'; ?>"><?php echo $sc['NAME']; ?></a></li>
              <?php endforeach; ?>
              </ul>
            <?php endif; ?>
	        </li>          
<?php endforeach; ?> 
          </ul>
<?php } ?>
