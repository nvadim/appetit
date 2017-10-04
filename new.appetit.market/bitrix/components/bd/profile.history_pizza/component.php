<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
Loader::includeModule('bd.deliverypizza');
use Bd\Deliverypizza;
global $USER;
$om = new Deliverypizza\Models\Order();
$orders = Deliverypizza\Entity\OrderTable::getList(array('filter'=>array('=USER_ID'=>$USER->GetID()),'order'=>array('ID'=>'desc')))->fetchAll();

$arResult['ORDERS'] = $orders;
function formatLabel($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}
$this->IncludeComponentTemplate();
?>

