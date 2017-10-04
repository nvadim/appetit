<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 * @var $USER CUser
 * @var $component SaleOrderAjax
 */

$context = Main\Application::getInstance()->getContext();
$request = $context->getRequest();
$server = $context->getServer();

$this->addExternalJs($templateFolder.'/script.js');

if (strlen($request->get('ORDER_ID')) > 0)
{
	include($server->getDocumentRoot().$templateFolder.'/confirm.php');
}
elseif ($arParams['DISABLE_BASKET_REDIRECT'] === 'Y' && $arResult['SHOW_EMPTY_BASKET'])
{
	include($server->getDocumentRoot().$templateFolder.'/empty.php');
}
else
{
    ?><script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script><?
    ?><div id="order-ajax-box"><?
    if($request->isAjaxRequest() && 'Y' == $request->get('ajaxOrder')) {
        $APPLICATION->RestartBuffer();
    }
    ?>
    <div class="checkout-form">
        <form action="<?= $APPLICATION->GetCurPage(); ?>" method="POST" name="ORDER_FORM" id="bx-soa-order-form"
              enctype="multipart/form-data" data-avar="<?= $arParams['ACTION_VARIABLE'] ?>">
            <?
            echo bitrix_sessid_post();

            if (strlen($arResult['PREPAY_ADIT_FIELDS']) > 0) {
                echo $arResult['PREPAY_ADIT_FIELDS'];
            }
            ?>
            <input type="hidden" name="location_type" value="code">
            <input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?= $arResult['BUYER_STORE'] ?>">
            <div class="col-lg-8 col-xl-8 col-sm-12 col-md-8 col-xs-12 pull-xs-left delivery-col">
                <div class="row fields-group">
                    <div class="row-label">Личные данные</div>
                    <div class="row fields">
                        <? foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $i => $prop) { ?>
                            <? if ($i != 0 && $i % 2 == 0) { ?>
                                <? $addClass = ' nopadl' ?>
                            <? } else { ?>
                                <? $addClass = '' ?>
                            <?
                            } ?>
                            <div class="col-lg-4 col-xl-4 col-sm-4 col-xs-6<?= $addClass ?>">
                                <div class="bd-input">
                                    <label class="text-xl-center"><?= $prop['NAME'] ?></label>
                                    <input type="text" name="<?= $prop['FIELD_NAME'] ?>" class="text-xs-left"
                                           value="<?= $prop['VALUE'] ?>">
                                </div>
                            </div>
                        <?
                        } ?>
                    </div>
                </div>
                <div class="row fields-group">
                    <div class="row-label font-fix">Информация по доставке</div>
                    <div class="row fields">
                        <div class="col-xs-12">
                            <div class="delivery-type-toggle font-fix"><!--
                                <? foreach ($arResult['DELIVERY'] as $i => $delivery) { ?>
                                <? if ($delivery['CHECKED'] == 'Y') {
                                    $curDelivery = $delivery['ID'];
                                } ?>
                                    --><a href="#"
                                          data-id="<?= $delivery['ID'] ?>"
                                    <?= $delivery['CHECKED'] == 'Y' ? ' class="active"' : '' ?>
                                ><?= $delivery['NAME'] ?><?= $delivery['PRICE'] > 0 ? ' (' . $delivery['PRICE_FORMATED'] . ')' : '' ?></a><!--
                                <? } ?>
                                -->

                            </div>
                            <input name="DELIVERY_ID" type="hidden" id="delivery_order_input" class="order-main-input" value="<?= $curDelivery ?>">
                            <div class="delivery-type-content">
                                <? foreach ($arResult['ORDER_PROP']['RELATED'] as $field) { ?>
                                    <?if (2 == $field['PROPS_GROUP_ID']) {?>
                                    <? switch ($field['TYPE']) {
                                        case 'LOCATION': { ?>
                                            <div class="row fields">
                                                <div class="col-lg-8 col-xl-8 col-sm-8 col-xs-12">
                                                    <div class="bd-input">
                                                        <label
                                                                class="text-xl-center"><?= $field['NAME'] ?></label>
                                                        <? foreach ($arResult['LOCATIONS'] as $input) { ?>
                                                            <?= current($input['output']) ?>
                                                            <?
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <? break;
                                        }
                                        case 'TEXT': { ?>
                                            <div class="row fields">
                                                <div class="col-lg-4 col-xl-4 col-sm-4 col-xs-6">
                                                    <div class="bd-input">
                                                        <label
                                                                class="text-xl-center"><?= $field['NAME'] ?></label>
                                                        <input name="<?= $field['FIELD_NAME'] ?>" type="text" value="<?= $field['VALUE'] ?>"
                                                               class="text-xs-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <? break;
                                        }
                                        case 'SELECT': {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-4 col-xl-4 col-sm-6 col-xs-6">
                                                    <select name="<?= $field['FIELD_NAME'] ?>"
                                                            class="cs-select cs-skin-slide">
                                                        <option
                                                                value="null"><?= GetMessage("checkout_delivery_take_away_where"); ?></option>
                                                        <? foreach ($field["VARIANTS"] as $variant): ?>
                                                            <option data-coordinate="<?= $variant['DESCRIPTION'] ?>"
                                                                    value="<?= $variant['VALUE'] ?>"
                                                                <?= $variant['SELECTED'] == 'Y' ? 'selected' : '' ?>
                                                            ><?= $variant['NAME'] ?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <script type="text/javascript">


                                                function init() {
                                                    myMap = new ymaps.Map("map", {
                                                        center: [<?= $field['VARIANTS'][0]['DESCRIPTION']; ?>],
                                                        zoom: 16
                                                    });

                                                    <?php foreach($field["VARIANTS"] as $ta_item): ?>
                                                    window.myPlacemark_<?php echo $ta_item['VALUE'] ?> = new ymaps.Placemark([<?php echo $ta_item['DESCRIPTION']; ?>], {
                                                        hintContent: '<?php echo $ta_item['NAME']; ?>',
                                                        balloonContent: 'Адрес: <?php echo $ta_item['NAME']; ?> <br />'
                                                    });

                                                    myMap.geoObjects.add(window.myPlacemark_<?php echo $ta_item['VALUE'] ?>);
                                                    <?php endforeach; ?>
                                                }
                                            </script>
                                            <div class="row map-row">
                                                <div class="col-lg-10 col-xl-10 col-sm-10 col-xs-12">
                                                    <div class="map-placeholder">
                                                        <div id="map"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?
                                        }
                                    } ?>

                                <? }
                                } ?>
                                <div class="row fields">
                                    <div class="col-lg-8 col-xl-8 col-sm-8 col-xs-12">
                                        <div class="bd-input textarea">
                                            <label class="text-xl-center">Комментарии к заказу</label>
                                            <textarea name="ORDER_DESCRIPTION" type="text"
                                                      class="text-xs-left"><?= $arResult['ORDER_DATA']['ORDER_DESCRIPTION']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?if ($arResult['addProp']['TIME']) {?>
                                    <input type="hidden"
                                           name="<?=$arResult['addProp']['TIME']['FIELD_NAME']?>"
                                           value="<?=$arResult['addProp']['TIME']['VALUE']?>"
                                           id="time_value_inp"
                                    >
                                    <div class="row">
                                        <div
                                                class="col-lg-12 col-xl-6 col-sm-12 col-xs-12 radios delivery-time-type_">
                                            <?=$arResult['addProp']['TIME']['NAME']?>
                                            <?foreach (array('Ближайшее', 'Точное') as $i => $type) {?>
                                                <label>
                                                    <input id = "type_<?= $i?>"
                                                            type="radio"
                                                            name="D_TYPE"
                                                            value="<?= $i?>"
                                                            <?= $i == $request->get('D_TYPE') ? 'checked' : ''?>>
                                                    <label for="type_<?= $i?>"><span></span></label><span><?= $type?></span>
                                                </label>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-xl-4 col-sm-8 col-xs-8 text-xs-right nopadl delivery-date-time_"
                                        <?= $request->get('D_TYPE') == 1 ? 'style="display: block"' : ''?>>
                                            <div class="col-xs-5 nopadl time-cont-r">
                                                <div class="bd-input<?= $request->get('D_TIME') ? ' filled':''?>">
                                                    <label class="text-xl-center">Время</label>
                                                    <input maxlength="5" type="text" name="D_TIME" value="<?= $request->get('D_TIME')?>"
                                                           class="text-xs-left">
                                                </div>
                                            </div>
                                            <div class="col-xs-7 nopad text-xs-left">
                                                <select name="D_DATE">
                                                    <option value="">Дата</option>
                                                    <?php
                                                    $iteration = 3;
                                                    if (\COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '0' || \COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) == '') {
                                                        $time = time();
                                                    } else {
                                                        $time = strtotime(\COption::GetOptionString('bd.deliverypizza', 'BD_SITE_TIMEZONE_OFFSET', '', SITE_ID) . ' hour');
                                                    }
                                                    for ($i = 0; $i <= $iteration; $i++) {
                                                        $value = FormatDate("j F", time() + ($i * 86400));
                                                        ?>
                                                        <option value="<?= $value?>" <?= $value == $request->get('D_DATE') ? 'selected' : ''?>><?= $value?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-sm-12 col-md-4 col-xs-12 payment-col pull-xs-right">
                <div class="payment-fields">
                    <div class="row fields-group">
                        <div class="row fields">
                            <div class="col-xs-12">
                                <select name="PAY_SYSTEM_ID" class="cs-select cs-skin-slide order-main-input">
                                    <option value="null" disabled="">Способ оплаты</option>
                                    <? foreach ($arResult["PAY_SYSTEM"] as $pay): ?>
                                        <option value="<?= $pay['ID'] ?>"<?= $pay['CHECKED'] == 'Y' ? ' selected': ''?>
                                        ><?= $pay['NAME'] ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?if ($arResult['addProp']['ODD_MONEY']) {?>
                            <div class="row fields">
                                <div class="col-xs-12">
                                    <div class="bd-input">
                                        <label class="text-xl-center"><?= $arResult['addProp']['ODD_MONEY']['NAME']?></label>
                                        <input type="text" name="<?= $arResult['addProp']['ODD_MONEY']['FIELD_NAME']?>" class="text-xs-left" value="<?= $arResult['addProp']['ODD_MONEY']['VALUE']?>"><?//TODO name?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <?if ($arResult['DELIVERY_PRICE'] > 0) { ?>
                        <div class="row fields-group">
                            <div class="row fields">
                                <div class="col-xs-12">
                                    <div class="bd-input">
                                        <label class="text-xs-center delivery-price-label font-fix _with-price">Стоимость товаров
                                            <span class="_delivery-price-value"><?=$arResult['ORDER_PRICE']?></span><span
                                                    class="currency"><?= CURRENCY_FONT; ?></span></label>
                                    </div>
                                    <div class="bd-input">
                                        <label class="text-xs-center delivery-price-label font-fix _with-price">Стоимость доставки
                                            <span class="_delivery-price-value"><?=$arResult['DELIVERY_PRICE']?></span><span
                                                    class="currency"><?= CURRENCY_FONT; ?></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <div class="row fields">
                    <div class="payment-footer">
                        <div class="total-row">
                            <div class="col-xs-4 order-total-container nopadl">
                                <div class="order-total">
                                    <div class="summary-label">Итого:</div>
                                    <div class="order-sum font-fix">
                                        <span><?= $arResult['ORDER_TOTAL_PRICE']?></span><span
                                                class="currency"><?= CURRENCY_FONT; ?></span></div>
                                    <?if ($arResult['DISCOUNT_PERCENT'] > 0) {?>
                                        <div class="order-discount"><?= GetMessage("checkout_discount"); ?>
                                            <span><?= $arResult['DISCOUNT_PERCENT'] ?></span>%
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                            <button name="save" value="Y" type="submit" class="send-order">Оформить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        <?
        // spike: for children of cities we place this prompt
        $city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
        ?>
        BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
            'source' => $component->getPath().'/get.php',
            'cityTypeId' => intval($city['ID']),
            'messages' => array(
                'otherLocation' => '--- '.Loc::getMessage('SOA_OTHER_LOCATION'),
                'moreInfoLocation' => '--- '.Loc::getMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
                'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.Loc::getMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.Loc::getMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
                        '#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
                        '#ANCHOR_END#' => '</a>'
                    )).'</div>'
            )
        ))?>);
    </script>
    <?
    if($request->isAjaxRequest() && 'Y' == $request->get('ajaxOrder')) {
       die();
    }
	?>
    </div>
	<div style="display: none">
		<?
		// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.steps',
			'.default',
			array(),
			false
		);
		$APPLICATION->IncludeComponent(
			'bitrix:sale.location.selector.search',
			'.default',
			array(),
			false
		);
		?>
	</div>


	<?
}
?>