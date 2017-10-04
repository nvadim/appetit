<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
global $USER;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/common.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bd.deliverypizza/controller/auth.php");
?>
<!DOCTYPE html>
<html>
<?php
$logo = \CFile::ResizeImageGet(\COption::GetOptionInt('bd.deliverypizza','BD_SITE_LOGO_MOBILE','',SITE_ID), array('width'=>112, 'height'=>20), BX_RESIZE_IMAGE_EXACT, true); ?>
  <head>
  	  <title><?$APPLICATION->ShowTitle()?> Аппетит Маркет</title>
      <?
	      \CJSCore::Init();
	       use Bitrix\Main\Page\Asset;
	       Asset::getInstance()->addString("<meta name='viewport' content='width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=no'>");
	       Asset::getInstance()->addString("<meta name='format-detection' content='telephone=no'>");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/currency.css");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/roboto.css");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/reset.css");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/selectordie.css");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/flickity.css");
		   Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/jquery.min.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/jquery.mmenu.all.min.umd.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/selectordie-min.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/min/flickity.pkgd-min.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/tmpl.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.maskedinput.min.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/sourcebuster.min.js");
		   Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/script.js");
		   $APPLICATION->ShowHead();
		   $user_ = \Bd\Deliverypizza\Entity\UserTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetch();
      ?>
	  <script type="text/javascript">
          window.currencyFont = '<?=CURRENCY_FONT; ?>';
          window.site_dir = '<?=SITE_DIR?>';
          window.user_id = <?=intval($USER->GetID());?>;
          window.phone_mask = '<?=COption::GetOptionString('bd.deliverypizza','BD_DELIVER_PHONE_MASK','',SITE_ID);?>';
          window.template_path = '<?=SITE_TEMPLATE_PATH; ?>';
          BX.message({login: '<?=GetMessage("login");?>'});
          BX.message({my_bonuses: '<?=GetMessage("my_bonuses");?>'});
          <?php if($USER->IsAuthorized()): ?>
          window.top_navbar = '<a href="'+window.site_dir+'my/edit/" class="settings-icon"><span class="icon"></span></a><a href="#" onclick="openMainProfileNav();" class="profile-icon"><span class="icon"></span>';
          <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID)=='Y'): ?>
          window.top_navbar += '<div class="login-text">'+BX.message('my_bonuses')+' <span class="bonus_value"><?=$user_['BONUS_VALUE']?> <span class="currency">'+window.currencyFont+'</span></span></div>';
          <?php endif; ?>
          window.top_navbar += '</a><a href="?logout=yes" class="logout-icon"><span class="icon"></span></a>'
          <?php else: ?>
          window.top_navbar = '<a href="#" class="profile-icon login-trigger"><span class="icon"></span><div class="login-text login-fixed guest">'+BX.message('login')+'</div></a>';
          <?php endif; ?>
          BX.message({add_basket: '<?=GetMessage("add_basket");?>'});
          BX.message({get_more: '<?=GetMessage("get_more");?>'});
          BX.message({get_another_clear: '<?=GetMessage("get_another_clear");?>'});
          BX.message({remaind: '<?=GetMessage("remaind");?>'});
          BX.message({remainded: '<?=GetMessage("remainded");?>'});
          BX.message({quantity: '<?=GetMessage("quantity");?>'});
          BX.message({quantitys: '<?=GetMessage("quantitys");?>'});
          BX.message({quantitys2: '<?=GetMessage("quantitys_2");?>'});
          BX.message({no_sale_title: '<?=GetMessage("no_sale_title");?>'});
          BX.message({get_another_gift: '<?=GetMessage("get_another_gift");?>'});
          BX.message({get_gift: '<?=GetMessage("get_gift");?>'});
          BX.message({good_luck_bitch: '<?=GetMessage("good_luck_bitch");?>'});
          BX.message({choise: '<?=GetMessage("choise");?>'});
          BX.message({censored: '<?=GetMessage("censored");?>'});
          BX.message({wok_js_box: '<?=GetMessage("wok_js_box");?>'});
          BX.message({submit_order: '<?=GetMessage("submit_order");?>'});
          BX.message({pay_order: '<?=GetMessage("pay_order");?>'});
          BX.message({gramm: '<?=GetMessage("gramm");?>'});
          BX.message({choise_address: '<?=GetMessage("choise_address");?>'});
          BX.message({type_delivery: '<?=GetMessage("type_delivery");?>'});
          BX.message({takeaway: '<?=GetMessage("takeaway");?>'});
          BX.message({address_delivery: '<?=GetMessage("address_delivery");?>'});
		  BX.message({destrict: '<?=GetMessage("destrict");?>'});
		  BX.message({choise_date: '<?=GetMessage("choise_date");?>'});
		  BX.message({ls: '<?=GetMessage("ls");?>'});
		  BX.message({history: '<?=GetMessage("history");?>'});
		  BX.message({auth_text: '<?=GetMessage("auth_text");?>'});
		  BX.message({forgot_password: '<?=GetMessage("forgot_password");?>'});
		  BX.message({agree_license: '<?=GetMessage("agree_license");?>'});
		  BX.message({homee: '<?=GetMessage("homee");?>'});
		  BX.message({appartaments: '<?=GetMessage("appartaments");?>'});
		  BX.message({wok_box_title: '<?=GetMessage("wok_box_title");?>'});
		  BX.message({wok_base: '<?=GetMessage("wok_base");?>'});
		  BX.message({wok_souce: '<?=GetMessage("wok_souce");?>'});
		  BX.message({wok_ready_box: '<?=GetMessage("wok_ready_box");?>'});
		  BX.message({wok_ingredients: '<?=GetMessage("wok_ingredients");?>'});
		  BX.message({change_destrict: '<?=GetMessage("change_destrict");?>'});
		  BX.message({wok_get_base: '<?=GetMessage("wok_get_base");?>'});
		  BX.message({wok_get_souce: '<?=GetMessage("wok_ready_box");?>'});
		  BX.message({wok_get_ready_box: '<?=GetMessage("wok_get_ready_box");?>'});
		  BX.message({mob_basket: '<?=GetMessage("mob_basket");?>'});
		  BX.message({mob_menu: '<?=GetMessage("mob_menu");?>'});

      </script>
      <meta property="og:type" content="article"/>
      <meta property="og:image" content="http://<?=$_SERVER['HTTP_HOST']?>/<?=$logo['src']?>">
  </head>
  <body id="body-h" class="<?if ($APPLICATION->GetCurPage(true) == SITE_DIR.'checkout/'): ?>auth-bg<?else:?><?endif?>">
  <?$APPLICATION->IncludeComponent(
      "bd:basket_pizza",
      "mobile",
      array(
        "COMPONENT_TEMPLATE" => "mobile",
		"IBLOCK_ID_EXTRA_ITEM" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_additional_products"][0],
		"IBLOCK_ID_RECOMEND" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_recommendation"][0],
		"IBLOCK_ID_PROMO" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_promo"][0]
      ),
      false
  );
  $APPLICATION->IncludeComponent("bd:gift.box_pizza", "mobile", Array(
      "IBLOCK_TYPE" => "gifts",
	  "IBLOCK_ID_GIFTS" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_gifts_pizza"]["bd_gifts_stickers"][0],
  ),
      false
  );

  include_once $_SERVER['DOCUMENT_ROOT'].'/my/moblie-main-view.php';
  $APPLICATION->IncludeComponent(
      "bd:auth_pizza",
      "mobile",
      array(
      ),
      false
  );
  ?>
    <div class="header"><a href="#menu"></a>
    <?if($APPLICATION->GetCurPage(false) === '/'): ?>
        <div class="title">
            <img src="<?php echo $logo['src'] ?>">
            <span></span>
        </div>

    <?else:?><div class="title"><span>
		    <?php $setted = 0; if($_SERVER['REQUEST_URI'] == '/checkout/'): $setted = 1;?><?=GetMessage("checkout_title");?><?php endif; ?>
		    <?php if((substr_count($_SERVER['REQUEST_URI'],'/news/') > 0 || substr_count($_SERVER['REQUEST_URI'],'/sales/') > 0 || substr_count($_SERVER['REQUEST_URI'],'/delivery/') > 0) && $setted == 0):$setted = 1;?><?=GetMessage("information_title");?><?php endif; ?>
            <?php if($_SERVER['REQUEST_URI'] == '/gifts/'): $setted = 1;?><?=GetMessage("gifts_title");?><?php endif; ?>

            <?php if($setted == 0): ?>Меню<?php endif; ?>


	    </span></div><?endif?>

      <div class="basket-toggle <?php if($_SESSION['BASKET_SUM'] > 0): ?>active_ <?php endif; ?>">
        <svg viewBox="0 0 32 32" <?php if($_SESSION['BASKET_SUM'] > 0): ?>style="display: none;" <?php endif; ?>><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg>
          <span <?php if($_SESSION['BASKET_SUM'] == 0): ?>style="display: none;" <?php endif; ?> class="basket-header-sum">
              <span><?=number_format($_SESSION['BASKET_SUM'],0,'.',' ')?></span>
              <span class="currency"><?=CURRENCY_FONT?></span>
          </span>
          <span class="close-basket">&#8249;</span>
      </div>
    </div>
	    <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "menu",
                            array(
                                "ROOT_MENU_TYPE" => "second",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "second",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "menu"
                            ),
                            false
                        );?>
    <div id="page">