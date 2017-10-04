<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
?>
<div id="product-detail" class="md-modal md-effect-3">
		        <div class="md-content">
			        <div class="spinner"></div>
			        <div class="row product product-detail">
				        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					        <div class="preview">
						        <div class="product-labels"></div>
						        <div class="without-sale" title="<?=GetMessage("no_sale_icon_title");?>"></div>
						        <img class="prod-image-l" src="">
						        <div class="likes">
							        <div class="like-content">
								        <div class="like-icon"></div><span>0</span>
							        </div>
						        </div>
					        </div>
				        </div>
				        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 nopadl">
					        <div class="product-info">
						        <div class="product-description">
							        <h3 class="font-fix"></h3>
							        <p></p>
						        </div>
						        <div class="product-energy"><a href="#"><?=GetMessage("zoom_item_energy_title");?></a>
							        <div class="energy-value-content">
								        <ul>
									        <li><span class="meta-property protein">
                              <div><?=GetMessage("zoom_item_energy_1");?></div></span><span class="meta-value"></span></li>
									        <li><span class="meta-property fats">
                              <div><?=GetMessage("zoom_item_energy_2");?></div></span><span class="meta-value"></span></li>
									        <li><span class="meta-property carbo">
                              <div><?=GetMessage("zoom_item_energy_3");?></div></span><span class="meta-value"></span></li>
									        <li>
										        <span class="meta-property energy">
                              <div><?=GetMessage("zoom_item_energy_4");?></div></span><span class="meta-value"></span></li>
								        </ul>
							        </div>
						        </div>
						        <div class="product-options"></div>
						        <div class="_detail-price-cont">
						        <div class="product-prices font-fix">
							        <span class="old-price"> <span class="line-through"></span><span class="currency"><?=CURRENCY_FONT; ?></span></span>
                                    <span class="current-price"><span></span><span class="currency"><?=CURRENCY_FONT; ?></span></span><span class="weight"><span></span><span></span></span>

						        </div>
						        </div>
						        <div class="product-actions">
							        <div class="progress-container" style="display: none;position: relative;">
								        <div style="width: 100%;" class="progress-bar"></div>
								        <div class="progress-bar-content font-fix">
									        <div></div>
								        </div>
							        </div>    
							        <a href="#" class="add-to-cart-btn"><?=GetMessage("zoom_item_add_to_basket");?></a>
						        
						        </div>
					        </div>
				        </div>
			        </div>
			        <div class="clearfix"></div>
		        </div>
	        </div>