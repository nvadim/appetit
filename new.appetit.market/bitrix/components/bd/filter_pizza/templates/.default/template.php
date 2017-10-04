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

?>
<?php if(count($tmp_[0]['VALUES'])): ?>
<a href="#" data-id="ingridients-filter" data-handler="popover" class="ingridients-filter-btn <?php if(!empty(${$FILTER_NAME})): ?>active<?php endif; ?>">
                <svg viewBox="0 0 51.997 51.997">
                  <path d="M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905 c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478 c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014 C52.216,18.553,51.97,16.611,51.911,16.242z M15.999,9.904c-4.411,0-8,3.589-8,8c0,0.553-0.447,1-1,1s-1-0.447-1-1 c0-5.514,4.486-10,10-10c0.553,0,1,0.447,1,1S16.551,9.904,15.999,9.904z"></path>
                </svg><span><?=GetMessage("filter");?></span></a>
                <?php if(!empty(${$FILTER_NAME})):?>
                <a href="<?php echo $arResult["JS_FILTER_PARAMS"]['SEF_DEL_FILTER_URL']; ?>" class="clear-filter-btn"><span><?=GetMessage("clear_filter");?></span></a>
                <?php endif; ?>

<div id="ingridients-filter" class="bd-popup">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
                <div class="row filter-params bd-scrollbar scrollbar-macosx font-fix">

                 <?php foreach ($arResult["ITEMS"] as $key=>$val): ?>
                     <?php  if($val['CODE']=='INGREDIENTS'): ?>
                         <?php foreach ($val['VALUES'] as $val=>$ar):?>
                            <?php if(!empty($ar["VALUE"])):?>
                                <div class="col-xs-6 param-item"><a href="#" class="icon-param remove-param <? echo $ar["EXCLUDE"]? 'selected': '' ?>">
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
                <div class="row filter-actions">
                  <button type="submit" id="set_filter" name="set_filter" class="apply-filter bx_filter_search_button" value="<?=GetMessage("apply_filter");?>"><?=GetMessage("apply_filter");?></button>
                  <button  type="submit" id="del_filter" name="del_filter" class="clear-filter bx_filter_search_reset"><?=GetMessage("clear_filter");?></button>
                </div>
    </form>
              </div>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>','', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
<?php endif; ?>