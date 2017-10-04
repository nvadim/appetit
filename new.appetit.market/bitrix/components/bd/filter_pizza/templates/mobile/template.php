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
$FILTER_NAME = (string)$arParams["FILTER_NAME"];
global ${$FILTER_NAME};
$tmp_ = array_values($arResult["ITEMS"]);
$count = 0;
foreach ($arResult["ITEMS"] as $key=>$val){
	$count = 0;
	foreach ($val['VALUES'] as $val=>$ar){
		if(!empty($ar["VALUE"])){
			if($ar["EXCLUDE"]){
				$count++;
			}
			if($ar["CHECKED"]){
				$count++;
			}
		}
	}
}

?>
<?php if(count($tmp_[0]['VALUES'])):?>
	<a href="#" class="filter-btn">
		<?php if($count>0): ?>
		<div class="count-badge"><?=$count?></div>
		<?php endif; ?>
		<svg viewBox="0 0 68.7546 54.1301">
			<path d="M17.0959,23h8.25a2.101,2.101,0,0,1,2.0959,2.0959v5.6877A2.101,2.101,0,0,1,25.3462,32.88h-8.25A2.1012,2.1012,0,0,1,15,30.7837V25.0959A2.1012,2.1012,0,0,1,17.0959,23h0ZM52.7841,67.0943H81.6584a2.09,2.09,0,0,1,1.4794.6157l0.0011,0.0011a2.09,2.09,0,0,1,.6157,1.4792V74.878a2.09,2.09,0,0,1-.6157,1.4792l-0.0011.0011a2.09,2.09,0,0,1-1.4794.6157H52.7841a2.09,2.09,0,0,1-1.4794-.6157l-0.0011-.0011a2.09,2.09,0,0,1-.6157-1.4792V69.19a2.09,2.09,0,0,1,.6157-1.4792l0.0011-.0011a2.09,2.09,0,0,1,1.4794-.6157h0Zm0-22.1252H81.6584a2.09,2.09,0,0,1,1.4794.6156l0.0011,0.0012a2.09,2.09,0,0,1,.6157,1.4791v5.6877a2.09,2.09,0,0,1-.6157,1.4791l-0.0011.0011a2.09,2.09,0,0,1-1.4794.6157H52.7841a2.09,2.09,0,0,1-1.4794-.6157l-0.0011-.0011a2.09,2.09,0,0,1-.6157-1.4791V47.065a2.09,2.09,0,0,1,.6157-1.4791l0.0011-.0012a2.09,2.09,0,0,1,1.4794-.6156h0Zm0-21.9691H81.6584a2.09,2.09,0,0,1,1.4794.6157l0.0011,0.0012a2.09,2.09,0,0,1,.6157,1.4791v5.6877a2.09,2.09,0,0,1-.6157,1.4791l-0.0011.0011a2.09,2.09,0,0,1-1.4794.6157H52.7841a2.09,2.09,0,0,1-1.4794-.6157l-0.0011-.0011a2.09,2.09,0,0,1-.6157-1.4791V25.0959a2.09,2.09,0,0,1,.6157-1.4791l0.0011-.0012A2.09,2.09,0,0,1,52.7841,23h0Zm-17.75,44.25h8.25a2.1011,2.1011,0,0,1,2.0959,2.096v5.6877A2.101,2.101,0,0,1,43.2841,77.13h-8.25a2.101,2.101,0,0,1-2.0959-2.0959V69.3465a2.1011,2.1011,0,0,1,2.0959-2.096h0Zm-17.938,0h8.25a2.101,2.101,0,0,1,2.0959,2.096v5.6877A2.1009,2.1009,0,0,1,25.3462,77.13h-8.25A2.1011,2.1011,0,0,1,15,75.0342V69.3465a2.1012,2.1012,0,0,1,2.0959-2.096h0ZM35.0339,45h8.25a2.1011,2.1011,0,0,1,2.0959,2.096v5.6877A2.101,2.101,0,0,1,43.2841,54.88h-8.25a2.101,2.101,0,0,1-2.0959-2.0959V47.0962A2.1011,2.1011,0,0,1,35.0339,45h0Zm-17.938,0h8.25a2.101,2.101,0,0,1,2.0959,2.096v5.6877A2.1009,2.1009,0,0,1,25.3462,54.88h-8.25A2.1011,2.1011,0,0,1,15,52.7839V47.0962A2.1012,2.1012,0,0,1,17.0959,45h0Zm17.938-22h8.25A2.1011,2.1011,0,0,1,45.38,25.0959v5.6877A2.1011,2.1011,0,0,1,43.2841,32.88h-8.25a2.1011,2.1011,0,0,1-2.0959-2.0959V25.0959A2.1011,2.1011,0,0,1,35.0339,23h0Z" transform="translate(-15 -23)" class="filter-path"></path>
		</svg></a>
<?php endif; ?>
<div class="filter-cont">
<?php if(count($tmp_[0]['VALUES'])): ?>
    <div id="ingridients-filter">
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
          <div class="filter-params-list">
	        	<?php foreach ($arResult["ITEMS"] as $key=>$val): ?>
                     <?php  if($val['CODE']=='INGREDIENTS'): ?>
                         <?php foreach ($val['VALUES'] as $val=>$ar):?>
                            <?php if(!empty($ar["VALUE"])):?>
            <div class="filter-param-item"><a href="#" class="icon-param remove-param <? echo $ar["EXCLUDE"]? 'selected': '' ?>">
                <svg viewBox="0 0 489.307 489.307">
                  <g>
                    <polygon points="489.307,56.466 432.839,0 244.654,188.187 56.468,0 0,56.466 188.186,244.654 0,432.839 56.469,489.307 244.654,301.121 432.839,489.307 489.306,432.839 301.121,244.654"></polygon>
                  </g>
                </svg></a><a href="#" class="icon-param add_param <? echo $ar["CHECKED"]? 'selected': '' ?>">
                <svg viewBox="0 0 51.997 51.997">
                  <path d="M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905 c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478 c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014 C52.216,18.553,51.97,16.611,51.911,16.242z M15.999,9.904c-4.411,0-8,3.589-8,8c0,0.553-0.447,1-1,1s-1-0.447-1-1 c0-5.514,4.486-10,10-10c0.553,0,1,0.447,1,1S16.551,9.904,15.999,9.904z"></path>
                </svg><span <? echo $ar["EXCLUDE"]? 'class="unchecked"': '' ?>><?=$ar["VALUE"];?></span></a>
                <?php
                    $val = 'N';
                    if($ar["EXCLUDE"]){
                        $val = 'E';
                    }
                    if($ar["CHECKED"]){
                       $val = 'Y';
                    }
                    ?>
              <input
                type="hidden"
                value="<?php echo $val; ?>"
                name="<? echo $ar["CONTROL_NAME"] ?>"
                id="<? echo $ar["CONTROL_ID"] ?>"
                <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                />
            </div>
                             <?php endif; ?>
                         <?php endforeach; ?>
                    <?php endif; ?>
                 <?php endforeach; ?>
          </div>
          <div class="filter-actions">
            <button type="submit" id="set_filter" name="set_filter" class="apply-filter bx_filter_search_button" value="<?=GetMessage("apply_filter");?>"><?=GetMessage("apply_filter");?></button>
            <button  type="submit" id="del_filter" name="del_filter" class="clear-filter bx_filter_search_reset"><?=GetMessage("clear_filter");?></button>
          </div>
    </form>
    </div>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>','', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
<?php endif; ?>
</div>