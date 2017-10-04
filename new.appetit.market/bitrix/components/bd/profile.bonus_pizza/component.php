<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
global $USER;
$user_ = Deliverypizza\Entity\UserTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID())))->fetch();
$orders = Deliverypizza\Entity\OrderTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID(),'=STATUS'=>7)))->fetchAll();
$usr_orders_sum = 0;
foreach ($orders as $order_) {
	$usr_orders_sum += $order_['ORDER_SUM'];
}
$next_level_sum = COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_'.(intval($user_['BONUS_LEVEL'])+2).'_LEVEL_ORDERS_SUM', '', SITE_ID);
$arResult['ORDERS_SUM'] = $usr_orders_sum;
$arResult['NEED_SUM'] = $next_level_sum - $usr_orders_sum;
$arResult['PERCENT'] = $usr_orders_sum*100 / COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_ORDERS_SUM', '', SITE_ID) ;

$this->IncludeComponentTemplate();
?>

