<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Доставка");
$APPLICATION->SetTitle("Доставка");
?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
<div class="content">
        <div class="status-bar detail-shadow"><a href="<?=SITE_DIR?>" class="back"></a>
          <div class="title"><?echo strip_tags($APPLICATION->GetTitle())?></div>
        </div>
        <div class="static-page">
		  <h2>Районы доставки:</h2>
		  <p>— Кировский</p>
		  <p>— Московский</p>
		  <p>— Красносельский</p>
		  <p>— Фрунзенский</p>
		  <h2>Условия доставки:</h2>
		  <p>— Минимальная сумма заказа 600 руб.</p>
		  <p>— Бесплатная доставка при заказа на сумму 600 руб.</p>
		  <p>— Время доставки в течение 60 минут.</p>
		  <p>(Возможность доставки в иные районы уточняйте у оператора call-центра).</p>
		  <h2>Самовывоз заказа:</h2>
		  <p>— г.Санкт-Петербург, проспект Народного Ополчения, дом 10 литер А</p>
		  <p>(Необходимо дождаться подтверждения заказа от оператора call-центра).</p>
          <h2><?=GetMessage("work_time_delivery");?></h2>		  
          <p>— ежедневно с 10:00 до 23:00</p>
		  <h2>Территориальная карта доставки:<h2>
          <div class="map-placeholder" id="map">
	          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/delivery_map.php", "EDIT_TEMPLATE" => ""),false);?>
	       </div>
        </div>
        <footer class="font-fix">
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
		  <h2>Районы доставки:</h2>
		  <p>— Кировский</p>
		  <p>— Московский</p>
		  <p>— Красносельский</p>
		  <p>— Фрунзенский</p>
		  <h2>Условия доставки:</h2>
		  <p>— Минимальная сумма заказа 600 руб.</p>
		  <p>— Бесплатная доставка при заказа на сумму 600 руб.</p>
		  <p>— Время доставки в течение 60 минут.</p>
		  <p>(Возможность доставки в иные районы уточняйте у оператора call-центра).</p>
		  <h2>Самовывоз заказа:</h2>
		  <p>— г.Санкт-Петербург, проспект Народного Ополчения, дом 10 литер А</p>
		  <p>(Необходимо дождаться подтверждения заказа от оператора call-центра).</p>
          <h2><?=GetMessage("work_time_delivery");?></h2>		  
          <p>— ежедневно с 10:00 до 23:00</p>
		  <h2>Территориальная карта доставки:<h2>
          <div class="map-placeholder" id="map">
	          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/delivery_map.php", "EDIT_TEMPLATE" => ""),false);?>
        </div>
      </main>
<?php endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>