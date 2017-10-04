<?php 
use Bd\Deliverypizza\Entity;
global $USER; $user = Entity\UserTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetch(); ?>
<div class="profile-cross-user-info">
  <div class="cont-item name-cont">
    <div><?=GetMessage("name");?> <?php echo $user['NAME']; ?></div>
    <div><?=GetMessage("mail");?> <?php
      $login = $USER->GetLogin();
      if(intval($login)!=0){
        $cleaned = preg_replace('/[^[:digit:]]/', '', $name);
        preg_match('/\d{1}(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

        $login = "+".PHONE_CODE." ({$matches[1]}) {$matches[2]}-{$matches[3]}";
      }
      echo $login;
      ?></div>
  </div>
  <?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
  <div class="cont-item bonuses-cont">
    <?=GetMessage("u_have_bonuses");?> <?php echo number_format($user['BONUS_VALUE'],0 ,'.',' '); ?> <span class="currency font-fix"><?=CURRENCY_FONT; ?></span>
  </div>
  <?php endif; ?>
  <div class="cont-item logout">
    <a href="?logout=yes"><?=GetMessage("exit");?></a>
  </div>
</div>