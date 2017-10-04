<div class="profile-view main-view" style="display: none;">
<div class="config-item"><a href="<?=SITE_DIR?>my/"><?=GetMessage("my_history_title");?></a></div>
 <?php if(\COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_ENABLED', '', SITE_ID)=='Y'): ?>
<div class="config-item"><a href="<?=SITE_DIR?>my/bonus/"><?=GetMessage("my_bonus_title");?></a></div>
<?php endif; ?>
<div class="config-item"><a href="<?=SITE_DIR?>my/edit/"><?=GetMessage("my_edit_title");?></a></div>
</div>