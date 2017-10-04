

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
<div class="container" style="background:#f7f7f7; padding: 15px;"><p align="center" style="position: relative;color: #aaa; font-size: 10px;">Внимание! Вся информация на сайте носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой
положениями ч.2 ст.437 Гражданского кодекса Российской Федерации. Для получения подробной информации о стоимости, наличии и составе блюд,
	пожалуйста, обращайтесь к оператору при оформлении заказа.</p></div>
  </body>
</html>