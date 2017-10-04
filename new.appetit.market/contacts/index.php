<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты");
$APPLICATION->SetTitle("Контакты");
?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
<div class="content">
    <div class="status-bar detail-shadow"><a href="<?=SITE_DIR?>" class="back"></a>
      <div class="title"><?echo strip_tags($APPLICATION->GetTitle())?></div>
    </div>
    <div class="static-page">
          <h2>Телефон Call-центра:</h2>
		  <p style="font-size: 22px;">+7 (812) 602-00-32</p>
		  <h2>Режим работы:</h2>
		  <p>с 10-00 до 23-00 (ежедневно)</p>
		  <h2>E-mail адрес:</h2>
		  <p><a href="mailto:appetit.market@mail.ru">appetit.market@mail.ru</a></p>
		  <h2>Группа ВКонтакте:</h2>
		  <p><a href="https://vk.com/appetit.market">https://vk.com/appetit.market</a></p>
		  <h2>Самовывоз:</h2>
		  <p>г.Санкт-Петербург, проспект Народного Ополчения, дом 10 литер А</p>
		  <p>(необходимо дождаться подтверждения заказа от оператора call-центра)</p>
		  <p><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A19019b276f826af2f17ac38e966efd0a698ea47c2b411999d8fe316066ebb75b&amp;width=678&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script></p>
    </div>
    <footer class="font-fix">.
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "bottom",
        array(
            "ROOT_MENU_TYPE" => "bottom_mob",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => array(
            ),
            "MAX_LEVEL" => "1",
            "CHILD_MENU_TYPE" => "bottom_mob",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "COMPONENT_TEMPLATE" => "menu"
        ),
        false
    );?>
    <div class="container">
        <div class="text-block">
            <div class="phone"><a href="tel:+<?=preg_replace('/\D/', '', \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID))?>"><?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID) ?></a></div>
            <div class="phone-desc"><?=GetMessage("delivery_fcng_awesome");?></div>
        </div>
        <div class="social-icons-footer">
<?$APPLICATION->IncludeComponent("bd:social_pizza", ".default", Array(
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
);?>
        </div>
    </div>
</footer>
      </div>
<?php else:?><!---Основная версия сайта ---->
      <main class="content container">
        <div class="grey-fw-container">
        <div class="container">
          <div class="row products-sub-menu font-fix">

          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
              <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div>
        </div>
        <div class="content-page page-simple delivery-page">
          <h2>Телефон Call-центра:</h2>
		  <p style="font-size: 22px;">+7 (812) 602-00-32</p>
		  <h2>Режим работы:</h2>
		  <p>с 10-00 до 23-00 (ежедневно)</p>
		  <h2>E-mail адрес:</h2>
		  <p><a href="mailto:appetit.market@mail.ru">appetit.market@mail.ru</a></p>
		  <h2>Группа ВКонтакте:</h2>
		  <p><a href="https://vk.com/appetit.market">https://vk.com/appetit.market</a></p>
		  <h2>Самовывоз:</h2>
		  <p>г.Санкт-Петербург, проспект Народного Ополчения, дом 10 литер А</p>
		  <p>(необходимо дождаться подтверждения заказа от оператора call-центра)</p>
		  <p><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A19019b276f826af2f17ac38e966efd0a698ea47c2b411999d8fe316066ebb75b&amp;width=678&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script></p>
        </div>
      </main>
<?php endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>