<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>
<header class="header">
	<div class="nav-line">
		<div class="wrap">
			<div class="row">
				<ul class="main-menu">
					<li  <?php if(substr_count($_SERVER['REQUEST_URI'],'/crm/')>0 && substr_count($_SERVER['REQUEST_URI'],'/clients/')==0 && substr_count($_SERVER['REQUEST_URI'],'/analytics/')==0): ?>class="active" <?php endif; ?>><a href="<?=SITE_DIR?>crm/"><?php echo GetMessage("head_orders"); ?></a></li>
					<li <?php if(substr_count($_SERVER['REQUEST_URI'],'/crm/clients/')>0): ?>class="active" <?php endif; ?>><a href="<?=SITE_DIR?>crm/clients/"><?php echo GetMessage("head_clients"); ?></a></li>
					<li <?php if(substr_count($_SERVER['REQUEST_URI'],'/crm/analytics/')>0): ?>class="active" <?php endif; ?>><a href="<?=SITE_DIR?>crm/analytics/"><?php echo GetMessage("head_analytics"); ?></a></li>
				</ul>
				<div class="logout-link"><?php echo GetMessage("head_user"); ?>  <span><?=$USER->GetLogin();?></span><a class="logout-bt" href="?logout=yes" title="<?php echo GetMessage("head_exit"); ?>" alt="<?php echo GetMessage("head_exit"); ?>"></a></div>
			</div>
		</div>
	</div>
