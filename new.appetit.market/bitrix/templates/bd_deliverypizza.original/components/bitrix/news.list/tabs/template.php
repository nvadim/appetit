<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
        <div class="container hidden-sm-down">
          <div class="row information-tabs">
            <div class="tabs tabs-style-flip">
              <nav>
                <ul>
	                <?foreach($arResult["ITEMS"] as $arItem):?>
                  <li><a href="#section-flip-<?echo $arItem["ID"]?>"><span><?echo $arItem["NAME"]?></span></a></li>
                  	<?endforeach;?>
                </ul>
              </nav>
              <div class="content-wrap">
	          <?foreach($arResult["ITEMS"] as $arItem):?>
	           <?
			   	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			   	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			   ?>
	          <?$arItem["ICON"] = CFile::GetPath($arItem["PROPERTIES"]["ICON"]["VALUE"]);?>
                <section id="section-flip-<?echo $arItem["ID"]?>">
                  <div class="row" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="col-xs-2">
                      <div class="image"><img src="<?=$arItem["ICON"]?>"></div>
                    </div>
                    <div class="col-xs-10">
                      <p>
                        <?echo $arItem["PREVIEW_TEXT"];?>                      
                      </p>
                    </div>
                  </div>
                </section>
              <?endforeach;?> 
              </div>
            </div>
          </div>