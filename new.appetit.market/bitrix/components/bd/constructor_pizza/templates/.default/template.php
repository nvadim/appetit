<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
        <div class="constructor-container">
          <form id="constructor_form">
            <input type="hidden" name="IS_CONSTRUCTOR" value="1"/>
            <input type="hidden" name="PRODUCT_ID" value="constructor"/>
            <input type="hidden" name="NAME" value="<?=GetMessage("pizza_box");?>"/>
            <input type="hidden" name="PRICE" value=""/>
            <input type="hidden" name="WEIGHT" value=""/>
            <input type="hidden" name="IMAGE" value="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-image.png');?>"/>
            <input type="hidden" name="BASE_ID"/>
            <input type="hidden" name="SOUSE_ID"/>
            <div class="title"><?=GetMessage("pizza_base");?></div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-6">
                <div class="base-list">
                  <?php foreach($arResult['BASE'] as $base): ?>
                  <div class="col-xs-6 nopadl">
                    <div class="constructor-item" data-target="BASE_ID" data-id="<?php echo $base['ID']; ?>">
                      <div class="col-xs-2 nopadl">
                        <div class="image"><img src="<?php echo CUtil::GetAdditionalFileURL($base['image']['src']); ?>">
                          <svg viewBox="0 0 17 13"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                        </div>
                      </div>
                      <div class="col-xs-10 nopadr">
                        <div class="name"><?php echo $base['NAME']; ?></div>
                        <div class="category"><?php echo $base['PREVIEW_TEXT']; ?></div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                  <div class="clearfix"></div>
                </div>
                <div class="title"><?=GetMessage("pizza_sous");?></div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="base-list">
                      <?php foreach($arResult['SOUSE'] as $souse): ?>
                      <div class="col-xs-6 nopadl">
                        <div class="constructor-item" data-target="SOUSE_ID" data-id="<?php echo $souse['ID']; ?>">
                          <div class="col-xs-2 nopadl">
                            <div class="image"><img src="<?php echo $souse['image']['src']; ?>">
                              <svg viewBox="0 0 17 13"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                            </div>
                          </div>
                          <div class="col-xs-10 nopadr">
                            <div class="name one-line"><?php echo $souse['NAME']; ?></div>
                            <div class="category"><?php echo $souse['PREVIEW_TEXT']; ?></div>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <div class="col-xs-6 pull-xs-right hidden-lg-down preset-image-big"><img src="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH.'/images/constructor-image.png');?>" style="border-radius: 50%;"></div>
            </div>
            <div class="title font-fix"><?=GetMessage("pizza_add_ingredients_title");?><span>&nbsp;&nbsp; <?php if(count($arResult['PRESETS']) > 0): ?><?=GetMessage("pizza_or");?> <?php endif; ?>&nbsp;</span>
              <?php if(count($arResult['PRESETS']) > 0): ?>
              <a href="#" class="get-preset"><?=GetMessage("pizza_add_box");?></a>
              <?php endif; ?>
            </div>
            <div class="row ingrs-cont">
              <div class="ingredients-list col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-6">
              </div>
              <div class="col-xs-12 add-ingredient-cont"><a href="#" class="add-ingredient font-fix"><?=GetMessage("pizza_add_ingredients");?></a></div>
            </div>
            <div class="row">
              <div class="col-xs-12 constructor-summary font-fix"><span><?=GetMessage("pizza_total");?></span>
                <div class="sum-value"><span>0</span><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                <div class="weight"><span>0</span> <?=GetMessage("weight");?></div>
              </div>
            </div>
            <div class="row col-xs-6">
              <button disabled="disabled" class="add-to-cart-constructor"><?=GetMessage("pizza_add_to_basket");?></button>
              <button class="clear-constructor"><?=GetMessage("pizza_clear_form");?></button>
            </div>
          </form>
        </div>
        <div class="constructor-panel">
          <div class="close-constructor-btn">
            <svg viewBox="0 0 129 129" enable-background="new 0 0 129 129">
            <path d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"></path>
            </svg>
          </div>
          <div class="section ingredients">
            <div class="new-ingredient">
              <div class="ingredient-categories">
                <div class="title font-fix"><?=GetMessage("pizza_chose_ingredients");?></div>
                <select class="cs-select cs-skin-slide constructor_cats_select">
                  <option value="null"><?=GetMessage("pizza_chose_category");?></option>
                  <?php foreach($arResult['FILLING_CATS'] as $key=>$filling_cat): ?>
                    <option <?php if($key==0): ?>selected<?php endif; ?> value="<?php echo $filling_cat['ID']; ?>"><?php echo $filling_cat['NAME']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="select-ingredients-cont">
                <div class="select-ingredients-list scrollbar-macosx">
                  <?php foreach($arResult['FILLING'] as $filling): ?>
                  <div data-id="<?php echo $filling['ID']; ?>" class="ingredient-item" data-section="<?php echo $filling['IBLOCK_SECTION_ID']; ?>" style="<?php if($arResult['FILLING_CATS'][0]['ID']!==$filling['IBLOCK_SECTION_ID']): ?>display: none;<?php endif; ?>">
                    <div class="name"><?php echo $filling['NAME']; ?></div>
                    <div class="delete" data-id="<?php echo $filling['ID']; ?>">&times;</div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <?php if(count($arResult['PRESETS']) > 0): ?>
          <div class="section presets">
            <div class="title font-fix"><?=GetMessage("pizza_add_box");?>
              <div class="select-preset-list scrollbar-macosx">
                <?php foreach($arResult['PRESETS'] as $preset): ?>
                <div class="preset-item row" data-filling="<?php echo implode(',',$preset['PROPS']['INGREDIENTS']['VALUE']); ?>" data-id="<?php echo $preset['ID']; ?>"  data-big-image="<?php echo CUtil::GetAdditionalFileURL($preset['big_image']['src']); ?>">
                  <div class="col-xs-4 nopad">
                    <div class="image"><img src="<?php echo CUtil::GetAdditionalFileURL($preset['image']['src']); ?>">
                      <svg viewBox="0 0 17 13"><path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z" transform="translate(-42 -44)"/></svg>
                    </div>
                  </div>
                  <div class="col-xs-8 nopadl">
                    <div class="name"><?php echo $preset['NAME']; ?></div>
                    <div class="description"><?php echo $preset['PREVIEW_TEXT'] ?></div>
                    <div class="preset-footer">
                      <div class="price"><?php echo $preset['price_s'] ?><span class="currency"><?=CURRENCY_FONT; ?></span></div>
                      <div class="weight"><?php echo $preset['weight_s'] ?> <?=GetMessage("weight");?></div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>

              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>