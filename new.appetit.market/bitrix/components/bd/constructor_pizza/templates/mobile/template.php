<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<div class="constructor">
	         <form id="constructor_form">
            <input type="hidden" name="IS_CONSTRUCTOR" value="1"/>
            <input type="hidden" name="PRODUCT_ID" value="constructor"/>
            <input type="hidden" name="NAME" value="<?=GetMessage("wok_box");?>"/>
            <input type="hidden" name="PRICE" value=""/>
            <input type="hidden" name="WEIGHT" value=""/>
            <input type="hidden" name="IMAGE" value="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-image.png');?>"/>
            <input type="hidden" name="BASE_ID"/>
            <input type="hidden" name="SOUSE_ID"/>
          <div class="constructor-view main-view">
            <div class="constructor-main-image"><img src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-image.png');?>"></div>
            <div class="constructor-config-list">
              <div class="config-item top-border-fix"><a href="#" onclick="getConstructorView('base')" data-var-name="base"><?=GetMessage("wok_base");?></a></div>
              <div class="config-item"><a href="#" onclick="getConstructorView('souse')" data-var-name="souse"><?=GetMessage("wok_sous");?></a></div>
              <?php if(count($arResult['PRESETS']) > 0): ?>
              <div class="config-item"><a href="#" onclick="getConstructorView('presets')" data-var-name="presets"><?=GetMessage("wok_add_box");?></a></div>
              <?php endif; ?>
            </div>
            <div class="constructor-ingredients-main">
              <div class="title"><?=GetMessage("wok_inside");?></div>
              <div class="row ingrs-cont">
                <div class="ingredients-list">

                </div>
              </div>
            </div>
            <div class="add-ingredient-cont"><a href="#" onclick="getConstructorView('add-ingredient')" class="add-ingredient font-fix"><span><?=GetMessage("wok_add_ingredients_title");?></span></a></div>
            <div class="clearfix"></div>
            <div class="constructor-summary font-fix"><span><?=GetMessage("wok_total");?></span>
              <div class="sum-value"><span>0</span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
              <div class="weight"><span>0</span> <?=GetMessage("weight");?></div>
            </div>
            </form>
            <div class="add-to-cart-cont">
              <button  disabled="disabled" type="submit" class="add-to-cart-constructor"><?=GetMessage("wok_add_to_basket");?></button>
                <a href="#" class="clear-constructor"><?=GetMessage('crate_new');?></a>
            </div>
          </div>

          <div class="constructor-view base-view">
            <div class="items-list">
	          <?php foreach($arResult['BASE'] as $base): ?>
              <div class="base-item"  data-var="base" data-target="BASE_ID" data-id="<?php echo $base['ID']; ?>">
                <div class="base-image">
                  <div class="image"><img src="<?php echo CUtil::GetAdditionalFileURL($base['image']['src']); ?>">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
                <div class="base-description">
                  <div class="name font-fix"><?php echo $base['NAME']; ?></div>
                  <div class="description"><?php echo $base['PREVIEW_TEXT']; ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>        
          <div class="constructor-view souse-view">
            <div class="items-list">
	          <?php foreach($arResult['SOUSE'] as $souse): ?>
              <div class="base-item" data-var="souse" data-target="SOUSE_ID" data-id="<?php echo $souse['ID']; ?>">
                <div class="base-image">
                  <div class="image"><img src="<?php echo $souse['image']['src']; ?>">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
                <div class="base-description">
                  <div class="name"><?php echo $souse['NAME']; ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="constructor-view presets-view">
            <div class="items-list">
	          <?php foreach($arResult['PRESETS'] as $preset): ?>
              <div class="base-item" data-filling="<?php echo implode(',',$preset['PROPS']['INGREDIENTS']['VALUE']); ?>" data-id="<?php echo $preset['ID']; ?>"  data-big-image="<?php echo CUtil::GetAdditionalFileURL($preset['big_image']['src']); ?>" data-var="presets">
                <div class="base-image">
                  <div class="image"><img src="<?php echo CUtil::GetAdditionalFileURL($preset['image']['src']); ?>">
                    <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                  </div>
                </div>
                <div class="base-description">
                  <div class="name"><?php echo $preset['NAME']; ?></div>
                  <div class="description"><?php echo $preset['PREVIEW_TEXT'] ?>
                  </div><span class="price"><span><?php echo $preset['price_s'] ?></span><span class="currency"><?=CURRENCY_FONT; ?></span></span><span class="weight"><?php echo $preset['weight_s'] ?> <?=GetMessage("weight");?></span>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="constructor-view add-ingredient-view ">
	        <?php foreach($arResult['FILLING_CATS'] as $key=>$filling_cat): ?>
            <div class="config-item"><a href="#" onclick="getConstructorView('ingredient-list')" data-id="<?php echo $filling_cat['ID']; ?>"><?php echo $filling_cat['NAME']; ?></a></div>
            <?php endforeach; ?>
          </div>
          <div class="constructor-view ingredient-list-view">
            <div  class="items-list checkboxes-mobile"  >
	           <?php foreach($arResult['FILLING'] as $filling): ?>
              <div class="bd-row-checkbox multi" data-section="<?php echo $filling['IBLOCK_SECTION_ID']; ?>" data-id="<?php echo $filling['ID']; ?>">
                  <div class="base-image">
                      <div class="image checkout_ico_checked">
                          <svg viewBox="0 0 16 16"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                      </div>
                  </div>
                  <span><?php echo $filling['NAME']; ?></span>
              </div>
               <?php endforeach; ?>
            </div>
          </div>
        </div>
