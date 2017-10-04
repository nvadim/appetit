<?php

use Bitrix\Sale\Basket;


require $_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php";

//CModule::AddAutoloadClasses(
//    '',
//    array(
//        '\Aers\Migration' => '/local/lib/Aers/Migration.php',
//        '\Aers\BasketController' => '/local/lib/Aers/BasketController.php',
//    )
//);

\Bitrix\Main\Loader::includeModule('sale');
\Bitrix\Main\Loader::includeModule('catalog');

$a = '{"products":[{"INDEX":2,"ID":"1836","NAME":"\u041e\u043a\u0443\u043d\u044c \u0432 \u0441\u043b\u0438\u0432\u043a\u0430\u0445","SORT":100,"CLASSES":"","APPEND_WITHOUT_SALE":"","PRICE":280,"OPTIONS":{"1":null,"2":null},"LOCAL_SUM":"280","IMAGE":"\/upload\/resize_cache\/iblock\/cf3\/60_60_2\/cf379884d26f53053999037d513628ef.JPG?15016876781675","SECTION":"\u0413\u043e\u0440\u044f\u0447\u0438\u0435 \u0431\u043b\u044e\u0434\u0430","SECTION_ID":"89","AMOUNT":1},{"INDEX":1,"ID":"1838","NAME":"\u041a\u0443\u0440\u0438\u0446\u0430 \u0432 \u043a\u0438\u0441\u043b\u043e-\u0441\u043b\u0430\u0434\u043a\u043e\u043c \u0441\u043e\u0443\u0441\u0435","SORT":100,"CLASSES":"","APPEND_WITHOUT_SALE":"","PRICE":260,"OPTIONS":{"1":null,"2":null},"LOCAL_SUM":"260","IMAGE":"\/upload\/resize_cache\/iblock\/692\/60_60_2\/692e3dec207998463d51a02494dfcb5a.jpg?15016931082475","SECTION":"\u0413\u043e\u0440\u044f\u0447\u0438\u0435 \u0431\u043b\u044e\u0434\u0430","SECTION_ID":"89","AMOUNT":1},{"INDEX":0,"ID":"1681","NAME":"\u0421\u0430\u043a\u0430\u0438","SORT":100,"CLASSES":"","APPEND_WITHOUT_SALE":"","PRICE":220,"OPTIONS":{"1":null,"2":null},"LOCAL_SUM":"220","IMAGE":"\/upload\/resize_cache\/iblock\/bf4\/60_60_2\/bf47969983134684c4489ec40cf73bea.jpg?15016890841934","SECTION":"\u0417\u0430\u043f\u0435\u0447\u0435\u043d\u043d\u044b\u0435 \u0440\u043e\u043b\u043b\u044b","SECTION_ID":"95","AMOUNT":1}],"basket_sum":760,"cashback":0,"delivery_price":0,"basket_sum_gift":760,"recommendation":{"single":{"ID":"1535","~ID":"1535","NAME":"\u0411\u0430\u043d\u043d\u0435\u0440","~NAME":"\u0411\u0430\u043d\u043d\u0435\u0440","PREVIEW_PICTURE":"1990","~PREVIEW_PICTURE":"1990","IBLOCK_SECTION_ID":null,"~IBLOCK_SECTION_ID":null,"PROPERTY_ADD_ITEM_VALUE":null,"~PROPERTY_ADD_ITEM_VALUE":null,"PROPERTY_ADD_ITEM_VALUE_ID":null,"~PROPERTY_ADD_ITEM_VALUE_ID":null,"PROPERTY_ADD_CATEGORY_VALUE":null,"~PROPERTY_ADD_CATEGORY_VALUE":null,"PROPERTY_ADD_CATEGORY_VALUE_ID":null,"~PROPERTY_ADD_CATEGORY_VALUE_ID":null,"PROPERTY_RECOMEND_CATEGORY_VALUE":null,"~PROPERTY_RECOMEND_CATEGORY_VALUE":null,"PROPERTY_RECOMEND_CATEGORY_VALUE_ID":null,"~PROPERTY_RECOMEND_CATEGORY_VALUE_ID":null,"PROPERTY_BG_COLOR_VALUE":null,"~PROPERTY_BG_COLOR_VALUE":null,"PROPERTY_BG_COLOR_VALUE_ID":null,"~PROPERTY_BG_COLOR_VALUE_ID":null,"PROPERTY_BUTTON_COLOR_VALUE":null,"~PROPERTY_BUTTON_COLOR_VALUE":null,"PROPERTY_BUTTON_COLOR_VALUE_ID":null,"~PROPERTY_BUTTON_COLOR_VALUE_ID":null,"PROPERTY_BUTTON_FONT_COLOR_VALUE":null,"~PROPERTY_BUTTON_FONT_COLOR_VALUE":null,"PROPERTY_BUTTON_FONT_COLOR_VALUE_ID":null,"~PROPERTY_BUTTON_FONT_COLOR_VALUE_ID":null,"PROPERTY_IS_BANER_VALUE":"Y","~PROPERTY_IS_BANER_VALUE":"Y","PROPERTY_IS_BANER_ENUM_ID":"43","~PROPERTY_IS_BANER_ENUM_ID":"43","PROPERTY_IS_BANER_VALUE_ID":"19902","~PROPERTY_IS_BANER_VALUE_ID":"19902","PROPERTY_URL_BANNER_VALUE":"\/delivery\/","~PROPERTY_URL_BANNER_VALUE":"\/delivery\/","PROPERTY_URL_BANNER_VALUE_ID":"19901","~PROPERTY_URL_BANNER_VALUE_ID":"19901","URL":"\/delivery\/","IMAGE":{"ID":"1990","TIMESTAMP_X":"23.05.2017 16:23:42","MODULE_ID":"iblock","HEIGHT":"348","WIDTH":"165","FILE_SIZE":"30592","CONTENT_TYPE":"image\/png","SUBDIR":"iblock\/b41","FILE_NAME":"b419bc6a8c90c36dd3d63977aba08d2d.png","ORIGINAL_NAME":"34efc71467970fa0e991825c9cab4066.png","DESCRIPTION":"","HANDLER_ID":null,"EXTERNAL_ID":"48c13215110ad93d9d154cc2a8c2c688","~src":false,"SRC":"\/upload\/iblock\/b41\/b419bc6a8c90c36dd3d63977aba08d2d.png?150169327591"}},"list":null}}';
//p(json_decode($a));

//$b = new Aers\BasketController();
//p($b->getBasketContent(true));

$a = 'a:5:{i:0;a:4:{s:10:"PRODUCT_ID";s:4:"1753";s:7:"OPTIONS";N;s:6:"AMOUNT";s:1:"2";s:10:"SECTION_ID";s:2:"90";}i:1;a:4:{s:10:"PRODUCT_ID";s:4:"1644";s:7:"OPTIONS";N;s:6:"AMOUNT";i:1;s:10:"SECTION_ID";s:2:"94";}i:2;a:4:{s:10:"PRODUCT_ID";s:4:"1980";s:7:"OPTIONS";N;s:6:"AMOUNT";i:1;s:10:"SECTION_ID";s:3:"107";}i:3;a:4:{s:10:"PRODUCT_ID";s:4:"1805";s:7:"OPTIONS";N;s:6:"AMOUNT";i:1;s:10:"SECTION_ID";s:2:"80";}s:4:"gift";a:7:{s:10:"PRODUCT_ID";s:4:"gift";s:7:"IS_GIFT";s:1:"1";s:10:"GIFT_LIMIT";s:4:"1600";s:6:"AMOUNT";i:1;s:7:"GIFT_ID";s:4:"2065";s:8:"GIFT_SUM";s:4:"1600";s:2:"ID";s:4:"gift";}}';
p(unserialize($a));

$a = new \Aers\BasketController();
$b = $a->getBasket();
p($b['SUM']);
p(unserialize($b['BASKET_CONTENT']));
//$basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), SITE_ID);
///** @var \Bitrix\Sale\BasketItem $bItem */
//foreach ($basket as $bItem) {
//    $result[$bItem->getId()] = array(
//        'PRODUCT_ID' => $bItem->getProductId(),
//        'AMOUNT' => $bItem->getQuantity(),
//        'PRICE' => $bItem->getPrice(),
//        'BASE_PRICE' => $bItem->getBasePrice(),
//
//    );
//    p($bItem->getPropertyCollection()->getPropertyValues());
//}
