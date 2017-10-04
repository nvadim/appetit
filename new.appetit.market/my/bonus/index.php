<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Бонусный счет");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;
?>
<?php
if($USER->IsAuthorized()): ?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
      <div class="content">
        <div class="status-bar"><a href="#" onclick="openMainProfileNav()" class="back"></a>
          <div class="title"><?=GetMessage("my_edit_title");?></div>
          <div class="profile">
	        
          <?$APPLICATION->IncludeComponent(
	"bd:profile.bonus_pizza", 
	"mobile", 
	array(),
	false
);
?>
        </div>
        <footer class="font-fix">
	<div class="container">
		<div class="text-block">
			<div class="phone"><a href="tel:+<?=preg_replace('/\D/', '', \COption::GetOptionString('bd.deliverysushi','BD_SITE_PHONE','',SITE_ID))?>"><?php echo \COption::GetOptionString('bd.deliverysushi','BD_SITE_PHONE','',SITE_ID) ?></a></div>
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
      <?php else: ?>
      <main class="content container">
        <div class="row">
          <div class="col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div> 
        </div>
        <?php include_once '../cross-user-info.php'; ?>
        <div class="profile-form">
          <div class="profile-tabs">
            <nav>
              <ul>
                <li><a href="<?=SITE_DIR?>my/"> 
                    <div class="profile-tab-icon history-icon">
                      <svg><path class="cls-1" d="M47.3165,40.023a1.9521,1.9521,0,0,1,1.3813.5746h0.0029a1.9548,1.9548,0,0,1,.5746,1.3842v8.9518l5.9114,5.9114,0.0006,0.0006a1.962,1.962,0,0,1,0,2.7689l-0.0006.0005-0.0006.0006a1.9621,1.9621,0,0,1-2.7689,0l-0.0006-.0006-6.4522-6.4523a2.0341,2.0341,0,0,1-.4422-0.6833l0.0006,0a1.9635,1.9635,0,0,1-.1162-0.3538V52.1224A1.9662,1.9662,0,0,1,45.3577,51.7V41.9818a1.9619,1.9619,0,0,1,1.9587-1.9588h0Z" transform="translate(-45.3577 -40.023)"/></svg>
                    </div><span><?=GetMessage("my_history_title");?></span></a></li>
					<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
                <li class="active"><a href="<?=SITE_DIR?>my/bonus/">
                    <div class="profile-tab-icon bonuses-icon">
                      <svg><path class="cls-1" d="M48.86,52.5505v0.5947h4.4147v2.1362H48.86v3.2139H45.6136V55.2814H43.1684V53.1452h2.4451V52.3821H43.1684V50.2457h2.4451V41.9092h5.7657a5.3259,5.3259,0,1,1,0,10.6413H48.86Zm0-2.5971h2.5191a1.8314,1.8314,0,0,0,1.5826-.766,3.2232,3.2232,0,0,0,.5482-1.9363,3.36,3.36,0,0,0-.5445-1.9632,1.8033,1.8033,0,0,0-1.5863-.7815H48.86v5.4471h0Z" transform="translate(-43.1684 -41.9092)"/></svg>
                    </div><span><?=GetMessage("my_bonus_title");?></span></a></li>
                    <?php endif; ?>
                <li><a href="<?=SITE_DIR?>my/edit/">
                    <div class="profile-tab-icon">
                      <svg><path class="cls-1" d="M45.3181,47.31c0,3.0209,1.9735,3.8862,2.64,4.7018a0.7072,0.7072,0,0,1,.1664.7574c-0.8595,2.1841-6.6821,1.563-6.6821,6.0308,0,0.0677.0025,0.1346,0.0068,0.2015H58.4513c0.004-.0669.0071-0.1339,0.0071-0.2015,0-4.4678-5.8226-3.8467-6.6821-6.0308a0.7066,0.7066,0,0,1,.1661-0.7574c0.6661-.8156,2.64-1.681,2.64-4.7018a4.6394,4.6394,0,1,0-9.2639,0h0Z" transform="translate(-41.442 -42.4077)"/></svg>
                    </div><span><?=GetMessage("my_edit_title");?></span></a></li>
              </ul>
            </nav>
          </div>
                    <?$APPLICATION->IncludeComponent(
	"bd:profile.bonus_pizza", 
	".default", 
	array(
	),
	false
);?>
        </div>
      </main>
      <?php endif; ?>
<?php else: ?>
<main class="content container">
  <div class="content-page page-404 font-fix error_text page-403">
    <h1><?=GetMessage("my_sorry_title");?></h1>
    <div class="status-icon icon-403"><span>403</span></div>
    <div class="status-title"><?=GetMessage("my_sorry_text");?></div>
  </div>
</main>
<?php endif; ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>