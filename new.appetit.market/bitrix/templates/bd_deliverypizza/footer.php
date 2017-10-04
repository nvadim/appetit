    <div class="footer-wrap">
        <div class="container">
          <footer>
            <div class="row">
                <div class="col-lg-7 col-xl-7 col-md-10 col-sm-12 col-xs-12">
                    <div class="clearfix">
                       <div class="footer-menu-title left">Меню</div>
                       <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_menu",
                            array(
                                "COMPONENT_TEMPLATE" => "",
                                "ROOT_MENU_TYPE" => "second",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => "",
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "second",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ),
                            false
                        );?>
                    </div>
                </div>
                <div class="col-lg-2 col-xl-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="footer-menu-title">Компания</div>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer_menu",
                        array(
                            "ROOT_MENU_TYPE" => "bottom",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => "info_menu"
                        ),
                        false
                    );?>
                </div>
                <div class="col-lg-3 col-xl-3 col-md-12 col-sm-12 col-xs-12 text-xl-right text-md-center text-xs-center text-sm-center">
                    <div class="phone">
                      <?php echo Helper::WrapFormatHTMLPhone(\COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID)) ?><br>
                      <p class="time-work">Доставка с 10:00-23:00</p>
                      <a href="#callback-submit" class="order-callback button green">Обратный звонок</a>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-xs-12 text-xl-left  text-md-left text-xs-center text-sm-center">
                <a href="https://vk.com/appetit.market" class="social-icon-vk" target="_blank">Вступайте в нашу группу ВКонтакте</a>
              </div>

	          <!--- Do not even try to remove this copyright --->
              <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6 col-xs-12 text-xl-right  text-md-right text-xs-center text-sm-center copyright"><a href="https://bdbd.shop/pizza/" target="_blank"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/copy.svg"><span>created by humans</span></a></div>
              <!--- Do not even try to remove this copyright --->
            </div>
          </footer>
	        <?$APPLICATION->IncludeComponent(
	"bd:detail.product_pizza",
	".default",
	array(
	),
	false
);?>
<p align="center" style="color: #aaa; margin-top: 50px; font-size: 10px">Внимание! Вся информация на сайте носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой
положениями ч.2 ст.437 Гражданского кодекса Российской Федерации. Для получения подробной информации о стоимости, наличии и составе блюд,
пожалуйста, обращайтесь к оператору при оформлении заказа.</p>
        </div>
    </div>
        <?
            $APPLICATION->IncludeComponent("bd:gift.box_pizza", ".default", Array(
				"IBLOCK_TYPE" => "gifts",
					"IBLOCK_ID_GIFTS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_gifts_pizza"]["bd_gifts_stickers"][0],
					"COMPONENT_TEMPLATE" => ".default"
				),
				false
			);
        ?>
<?$APPLICATION->IncludeComponent(
	"bd:basket_pizza",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID_EXTRA_ITEM" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_additional_products"][0],
		"IBLOCK_ID_RECOMEND" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_recommendation"][0],
		"IBLOCK_ID_PROMO" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_promo"][0]
	),
	false
);
?>
<?$APPLICATION->IncludeComponent(
	"bd:auth_pizza",
	".default",
	array(
	),
	false
);?>

        <div class="md-overlay"></div>
      </div>
    </div>
        <script type="text/javascript">var ga;</script>
        <?php
        $metrika = \COption::GetOptionString('bd.deliverypizza','BD_DELIVER_M','',SITE_ID);
        $ga = \COption::GetOptionString('bd.deliverypizza','BD_DELIVER_GA','',SITE_ID);
        if(!empty($metrika)):?>
	        <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter = new Ya.Metrika({id:<?=$metrika;?>, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/30164019" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
        <?php endif; ?>
        <?php if(!empty($ga)):?>

        <?php endif; ?>
	        <!--Google analytics-->
	       <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57920286-29', 'auto');
  ga('send', 'pageview');

</script>
	        <!--Google analytics-->
        <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/any_scripts.php", "EDIT_TEMPLATE" => ""),false);?>

        <?$APPLICATION->IncludeComponent(
            "custom:banners.prototype",
            "",
            array(
                "IBLOCK_ID" => "69",
                "CACHE_TIME" => 36000000
            ),
            false,
            array(
                "HIDE_ICONS" => "Y"
            )
        );?>
  </body>
</html>