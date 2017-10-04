<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$_SESSION['SITE_ID'] = SITE_ID;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
global $USER;
if(isset($_POST['login']) && isset($_POST['password'])){

	if($USER->Login($_POST['login'],$_POST['password'])){
		LocalRedirect(SITE_DIR.'/crm/');
	}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title><?php echo GetMessage("enter_crm"); ?></title>
	<link href="<?=SITE_DIR?>crm/static/css/style.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
	<div class="box-main">
		<a href="<?=SITE_DIR?>" class="back"><?php echo GetMessage("back_to_site"); ?></a>
		<div class="center-row">
			<div class="center-col">
				<div class="logo"><img src="<?=SITE_DIR?>crm/static/img/logo.png" alt="logo"></div>
				<div class="form">
					<form action="" method="post">
						<div class="form-ln"><input type="text" name="login" class="login" placeholder="<?php echo GetMessage("login"); ?>"></div>
						<div class="form-ln"><input type="password" name="password" class="password" placeholder="<?php echo GetMessage("password"); ?>"></div>
						<div class="form-ln"><input type="submit" value="<?php echo GetMessage("enter"); ?>"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div><!-- .wrapper -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="<?=SITE_DIR?>crm/static/js/jquery.uniform.min.js"></script>
<script src="<?=SITE_DIR?>crm/static/js/selectordie.min.js"></script>
<script src="<?=SITE_DIR?>crm/static/js/script.js"></script>
</body>
</html>