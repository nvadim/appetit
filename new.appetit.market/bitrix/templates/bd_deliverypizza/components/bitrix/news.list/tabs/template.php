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
              <div class="content-wrap col-xs-8">

	          <?foreach($arResult["ITEMS"] as $arItem):?>
	           <?
			   	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			   	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			   ?>
	          <?$arItem["ICON"] = CFile::GetPath($arItem["PROPERTIES"]["ICON"]["VALUE"]);?>
                <section id="section-flip-<?echo $arItem["ID"]?>">
                  <div class="row" id="<?=$this->GetEditAreaId($arItem['ID']);?>">


                      <p>
                        <?echo $arItem["PREVIEW_TEXT"];?>
                      </p>
                  </div>
                </section>
              <?endforeach;?>


              </div>
              <div class="col-xs-4 clearfix">
                <div class="social-w">
                  <script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

                  <!-- VK Widget -->
                  <div id="vk_groups"></div>
                  <script type="text/javascript">
                  VK.Widgets.Group("vk_groups", {mode: 3, width: "250", color1: 'F8F8F8', color3: 'F80A3C'}, 75482961);
                  </script>
                </div>
              </div>
            </div>
          </div>