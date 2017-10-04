<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);
foreach ($arResult['ORDER_PROP']['RELATED'] as &$prop) {
    if (in_array($prop['CODE'], array('TIME', 'ODD_MONEY'))) {
        $arResult['addProp'][$prop['CODE']] = $prop;
    }
    if ('PICK_UP' == $prop['CODE']) {
        $ar = \Bitrix\Sale\Internals\OrderPropsVariantTable::getList(array(
            'filter' => array('ORDER_PROPS_ID' => $prop['ID']),
            'select' => array('VALUE', 'DESCRIPTION')
        ))->fetchAll();
        foreach ($prop['VARIANTS'] as &$variant) {
            foreach ($ar as $item) {
                if ($variant['VALUE'] == $item['VALUE']) {
                    $variant['DESCRIPTION'] = $item['DESCRIPTION'];
                }
            }
        }
        unset($variant);
    }
}
unset($prop);