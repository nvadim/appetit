<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/common.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/auth.php");
?>
<!DOCTYPE html>
<html>
  <head>
     	<title><?$APPLICATION->ShowTitle()?> Аппетит Маркет</title>

	 <?
	   $logo = \CFile::GetFileArray(\COption::GetOptionInt('bd.deliverypizza','BD_SITE_LOGO','',SITE_ID));
	   $sharing_file = CFile::GetFileArray(COption::GetOptionString('bd.deliverypizza','BD_SHARING_IMG','',SITE_ID));

	   \CJSCore::Init();
	   use Bitrix\Main\Page\Asset;
	   Asset::getInstance()->addString("<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>");
	   Asset::getInstance()->addString("<meta name='SKYPE_TOOLBAR' content='SKYPE_TOOLBAR_PARSER_COMPATIBLE' />");
	   Asset::getInstance()->addString("<meta name='format-detection' content='telephone=no' />");
	   Asset::getInstance()->addString("<link rel='shortcut icon' href='/favicon.ico' type='image/x-icon' />");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/animate.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/popover.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/selectordie.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/currency.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/flickity.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/jquery.scrollbar.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/roboto.css");
	   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/jquery.fancybox.css");
     Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/js/slick/slick.css");
     Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/js/slick/slick-theme.css");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/jquery.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/tether.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/tmpl.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/bootstrap.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/popover.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/selectordie-min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/tabs.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/modal.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/jquery.scrollbar-min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/flickity.pkgd-min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.fancybox.pack.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.maskedinput.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/cookie.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/sourcebuster.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/share.js");
     Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/slick/slick.min.js");
	   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/script.js");
	   $APPLICATION->ShowHead();
	   global $USER;
    ?>

   	<noindex>
   	<!--[if IE 9]>
   		<script src="https://cdn.rawgit.com/scottjehl/picturefill/3.0.2/dist/picturefill.min.js"></script>
   		<![endif]-->
      <script type="text/javascript">
          window.currencyFont = '<?=CURRENCY_FONT; ?>';
          window.user_id = <?=intval($USER->GetID());?>;
          window.phone_mask = '<?=COption::GetOptionString('bd.deliverypizza','BD_DELIVER_PHONE_MASK','',SITE_ID);?>';
          window.phone_code = '<?=PHONE_CODE?>'
          window.template_path = '<?=SITE_TEMPLATE_PATH; ?>';
          BX.message({add_basket: '<?=GetMessage("add_basket");?>'});
          BX.message({get_more: '<?=GetMessage("get_more");?>'});
          BX.message({remaind: '<?=GetMessage("remaind");?>'});
          BX.message({remainded: '<?=GetMessage("remainded");?>'});
          BX.message({quan: '<?=GetMessage("quan");?>'});
          BX.message({quanti: '<?=GetMessage("quanti");?>'});
          BX.message({quantitys: '<?=GetMessage("quantitys");?>'});
          BX.message({no_sale_title: '<?=GetMessage("no_sale_title");?>'});
          BX.message({get_another_gift: '<?=GetMessage("get_another_gift");?>'});
          BX.message({good_luck_bitch: '<?=GetMessage("good_luck_bitch");?>'});
          BX.message({choise: '<?=GetMessage("choise");?>'});
          BX.message({censored: '<?=GetMessage("censored");?>'});
          BX.message({wok_js_box: '<?=GetMessage("wok_js_box");?>'});
          BX.message({submit_order: '<?=GetMessage("submit_order");?>'});
          BX.message({pay_order: '<?=GetMessage("pay_order");?>'});
          BX.message({gramm: '<?=GetMessage("gramm");?>'});
      </script>
     </noindex>
      <meta property="og:type" content="article"/>
      <meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>">
      <meta property="og:image" content="http://<?=$_SERVER['HTTP_HOST'].$sharing_file['SRC']?>">
      <meta property="og:title" content="<?=COption::GetOptionString('bd.deliverypizza','BD_SHARING_TITLE','',SITE_ID)?>">
      <meta property="og:description" content="<?=COption::GetOptionString('bd.deliverypizza','BD_CF_SHARING_DESC','',SITE_ID)?>">
<meta name="yandex-verification" content="86985587b89694d3" />
<meta name="google-site-verification" content="G7o7q3OuXPXjT9WiLbGPO-cvf7qLzT2zbx2clGKeQzs" />
<meta name='wmail-verification' content='bf63a178391c8de4737624b81ff102aa' />
<meta name="msvalidate.01" content="F142DD557013FD628A7F36AAC0CDA31B" />
  </head>
  <body class=" <?if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'): ?> index-page<?else:?> category-page<?endif?><?php if(COption::GetOptionString('bd.deliverypizza','BD_DELIVERY_FIXED_HEADER','',SITE_ID)=='Y'): ?> fixed-header<?php endif; ?>">
  <div id="panel"><?$APPLICATION->ShowPanel(); CModule::IncludeModule("iblock");?></div>
  	<div class="main-container <?php if(substr_count($_SERVER['REQUEST_URI'],'/catalog/')==0 || substr_count($_SERVER['REQUEST_URI'],'/constructor/')>0): ?>not-catalog<?php endif; ?>">
      <header>
        <div class="top-line font-fix">
          <div class="container">
            <div class="row">
              <div class="col-xl-8 col-lf-8 col-md-6 col-sm-7 col-xs-6">
                <div class="logo">

	                <? if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'): ?><?else:?><a href="<?=SITE_DIR?>"><?endif?>
		                <img src="<?php echo $logo['SRC'] ?>">
                    <span class="logo-name">Appetit Market</span>
                    <span class="logo-sign">служба доставки</span>
		            <? if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php'): ?><?else:?></a><?endif?>
		        </div>
                <div class="information-btn"><a href="#" data-id="information" data-handler="popover">
                    <svg viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;"><path d="M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M280.5,382.5h-51v-153h51V382.5z M280.5,178.5h-51v-51h51V178.5z"/></svg><span><?=GetMessage("header_menu_information");?></span></a></div>
                <div id="information" class="bd-popup">
                    <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "info_menu",
                            array(
                                "ROOT_MENU_TYPE" => "top",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "top",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "info_menu"
                            ),
                            false
                        );?>
                </div>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "info_menu_header",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "top",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "COMPONENT_TEMPLATE" => "info_menu"
                    ),
                    false
                );?>
              </div>

              <div class="col-xl-4 col-lf-4 col-md-6 col-sm-5 col-xs-6 text-xs-right">
                <div class="phone hidden-md-down">
                  <?php echo Helper::WrapFormatHTMLPhone(\COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID)) ?><br>
                  <?$APPLICATION->IncludeComponent(
	"altasib:feedback.form",
	"callback",
	array(
		"ACTIVE_ELEMENT" => "Y",
		"ADD_HREF_LINK" => "Y",
		"AGREEMENT" => "Y",
		"ALX_LINK_POPUP" => "Y",
		"ALX_LOAD_PAGE" => "N",
		"ALX_NAME_LINK" => "Заказать обратный звонок",
		"BBC_MAIL" => "",
		"CAPTCHA_TYPE" => "default",
		"CATEGORY_SELECT_NAME" => "Выберите категорию",
		"CHANGE_CAPTCHA" => "N",
		"CHECKBOX_TYPE" => "CHECKBOX",
		"CHECK_ERROR" => "Y",
		"COLOR_OTHER" => "#b3ce00",
		"COLOR_SCHEME" => "PALE",
		"COLOR_THEME" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"EVENT_TYPE" => "ALX_FEEDBACK_FORM",
		"FB_TEXT_NAME" => "",
		"FB_TEXT_SOURCE" => "DETAIL_TEXT",
		"FORM_ID" => "1",
		"IBLOCK_ID" => "6",
		"IBLOCK_TYPE" => "altasib_feedback",
		"INPUT_APPEARENCE" => array(
			0 => "FLOATING_LABELS",
		),
		"JQUERY_EN" => "N",
		"LINK_SEND_MORE_TEXT" => "",
		"LOCAL_REDIRECT_ENABLE" => "N",
		"MASKED_INPUT_PHONE" => array(
			0 => "PHONE",
		),
		"MESSAGE_OK" => "Наш оператор перезвонит вам в ближайшее время.",
		"NAME_ELEMENT" => "ALX_DATE",
		"NOT_CAPTCHA_AUTH" => "Y",
		"POPUP_ANIMATION" => "4",
		"PROPERTY_FIELDS" => array(
			0 => "FIO",
			1 => "PHONE",
		),
		"PROPERTY_FIELDS_REQUIRED" => array(
			0 => "PHONE",
		),
		"PROPS_AUTOCOMPLETE_EMAIL" => array(
			0 => "EMAIL",
		),
		"PROPS_AUTOCOMPLETE_NAME" => array(
			0 => "FIO",
		),
		"PROPS_AUTOCOMPLETE_PERSONAL_PHONE" => array(
			0 => "PHONE",
		),
		"PROPS_AUTOCOMPLETE_VETO" => "N",
		"SECTION_FIELDS_ENABLE" => "N",
		"SECTION_MAIL_ALL" => "sendmail@ayers.ru",
		"SEND_IMMEDIATE" => "Y",
		"SEND_MAIL" => "N",
		"SHOW_LINK_TO_SEND_MORE" => "Y",
		"SHOW_MESSAGE_LINK" => "Y",
		"USERMAIL_FROM" => "N",
		"USE_CAPTCHA" => "Y",
		"WIDTH_FORM" => "480px",
		"COMPONENT_TEMPLATE" => "callback"
	),
	false
);?>
                </div>
                 <div class="auth-block">
               <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
	"COMPONENT_TEMPLATE" => "auth",
		"REGISTER_URL" => "",
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL" => SITE_DIR."my/",
		"SHOW_ERRORS" => "N",
	),
	false
);?></div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <div class="product-categories-container grey-fw-container">
          <div class="container container-top-menu">
            <div class="row">
	           <nav class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-xs-7">
	            <?$APPLICATION->IncludeComponent("bitrix:menu", "general_menu_icons", Array(
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
</nav>
              <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-xs-5 basket-btn-container text-xs-right">
	              	              <a href="#" data-id="basket" data-placement="bottom-left" data-handler="popover" class="basket-btn">
                  <div class="empty-basket" <?php if($_SESSION['BASKET_SUM']>0): ?> style="display: none;" <?php endif; ?>><i class="bd-round-icon">
                      <svg viewBox="0 0 32 32"><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg></i></div>
                  <div class="not-empty-basket" <?php if($_SESSION['BASKET_SUM']>0): ?> style="display: block;" <?php endif; ?>>
                    <svg viewBox="0 0 32 32"><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg><span class="basket-sum"><span><?php echo number_format($_SESSION['BASKET_SUM'],0 ,'.',' '); ?></span><span class="currency font-fix"><?=CURRENCY_FONT; ?></span></span>
                  </div>
                  <div class="close-basket">
                    <div class="bd-round-icon">
                      <svg viewBox="0 0 129 129" enable-background="new 0 0 129 129">
                        <path d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"></path>
                      </svg>
                    </div>
                  </div></a>

              </div>
            </div>
          </div>
        </div>
      </header>

