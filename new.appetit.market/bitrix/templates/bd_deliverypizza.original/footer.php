        <div class="container">
          <footer>
            <div class="row">
              <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-xs-4">
					<?=\COption::GetOptionString('bd.deliverypizza','BD_SITE_COMPANY','',SITE_ID);?>
              </div>
              <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-xs-4 text-xs-center social-icons-footer">
	                     <?$APPLICATION->IncludeComponent("bd:social_pizza", ".default", Array(
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?> 
	          </div>
	          <!--- Do not even try to remove this copyright --->
              <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-xs-4 text-xs-right copyright"><a href="https://bdbd.shop/pizza/" target="_blank"><img src="<?php echo SITE_TEMPLATE_PATH ?>/images/copy.svg"><span>created by humans</span></a></div>
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
  </body>
</html>