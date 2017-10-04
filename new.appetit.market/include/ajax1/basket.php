<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bd\Deliverypizza;
use \Bitrix\Main\Loader;

Loader::includeModule('sale');
Loader::includeModule('catalog');
if (isset($_GET['action']) && $_GET['action'] == 'addToBasket') {
    $basket_m = new \Aers\BasketController();
    if (!isset($_POST['IS_CONSTRUCTOR'])) {
        if (isset($_POST['IS_GIFT'])) {
            if (key_exists('gift', $basket_m->getBasket())) {
                echo \Bitrix\Main\Web\Json::encode(array('error'=>'Подарок уже выбран'));
                exit;
            }
            $arSelect = Array("ID","PROPERTY_STICKER");
            $arFilter = Array("IBLOCK_ID"=>\Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_gifts"]["bd_gifts"][0], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",'ID'=>$_POST['PRODUCT_ID']);
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
            while($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();

                $arSelect = Array("ID", "PROPERTY_ORDER_FROM");
                $arFilter = Array("IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_gifts"]["bd_gifts_stickers"][0], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", 'ID' => $arFields['PROPERTY_STICKER_VALUE']);
                $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
                while ($ob = $res->GetNextElement()) {
                    $arFields_ = $ob->GetFields();
                    if ($_SESSION['BASKET_SUM_GIFT'] >= $arFields_['PROPERTY_ORDER_FROM_VALUE']) {
                        $_SESSION['GIFT_ID'] = $_POST['PRODUCT_ID'];
                        $prop = array(
                            array('NAME' => 'gift', 'CODE' => 'GIFT', 'VALUE' => 'Y'),
                            array('NAME' => 'gift sum', 'CODE' => 'GIFT_SUM', 'VALUE' => $arFields_['PROPERTY_ORDER_FROM_VALUE'] )
                        );
                        Add2BasketByProductID($_POST['PRODUCT_ID'], 1, array(), $prop);
                    } else {
                        echo \Bitrix\Main\Web\Json::encode(array('error' => GetMessage("summ_for_gift_not_enough")));
                        exit;
                    }
                }
            }
        } else {
            Add2BasketByProductID($_POST['PRODUCT_ID']);
        }

    }
    $result = $basket_m->getBasketContent();
    echo \Bitrix\Main\Web\Json::encode($result);
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'getBasket') {
    $basket_m = new \Aers\BasketController();
    $result = $basket_m->getBasketContent();
    echo \Bitrix\Main\Web\Json::encode($result);
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'changeAmount') {
    $basket_m = new \Aers\BasketController();
    if ($basket_m->changeAmount($_POST['PRODUCT_ID'], $_POST['AMOUNT'])) {
        $result = $basket_m->getBasketContent();
        echo \Bitrix\Main\Web\Json::encode($result);
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $basket_m = new \Aers\BasketController();
    if ($basket_m->removeItem($_POST['PRODUCT_ID'])) {
        $result = $basket_m->getBasketContent();
        echo \Bitrix\Main\Web\Json::encode($result);
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'removeGift') {
    $basket_m = new \Aers\BasketController();
    $basket_m->removeGift();
    $result = $basket_m->getBasketContent();
    echo \Bitrix\Main\Web\Json::encode($result);
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'getBasketItemDetail') {
    Loader::includeModule('iblock');
    $basket_m = new \Aers\BasketController();
    $basket = $basket_m->getBasket();
    $content = unserialize($basket['BASKET_CONTENT']);
    if (is_numeric($content[$_POST['PRODUCT_ID']]['PRODUCT_ID'])) {
        $bOb = $content[$_POST['PRODUCT_ID']];
        $result = array();
        $result['TYPE'] = 'native';

        $props = array();
        $prod_id = $content[$_POST['PRODUCT_ID']];
        $base = CIBlockElement::GetByID($prod_id['PRODUCT_ID'])->GetNext();
        $db_props = CIBlockElement::GetProperty(\Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_content"]["bd_catalog"][0], $prod_id['PRODUCT_ID'], array("sort" => "asc"), Array());
        while ($ar_props = $db_props->GetNext())
            $props[$ar_props['CODE']] = $ar_props['VALUE'];

        $result['ID'] = $base['ID'];
        $result['NAME'] = $base['NAME'];
        $result['PREVIEW_TEXT'] = $base['PREVIEW_TEXT'];
        if ($base['PREVIEW_PICTURE'])
            $result['PREVIEW_PICTURE'] = \CFile::ResizeImageGet($base['PREVIEW_PICTURE'], Array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_EXACT);
        else
            $result['PREVIEW_PICTURE']['src'] = SITE_TEMPLATE_PATH . '/images/no_photo.jpg';
        if ($base['PREVIEW_PICTURE']) {
            $result['PREVIEW_PICTURE_M'] = \CFile::ResizeImageGet($base['PREVIEW_PICTURE'], Array("width" => 300, "height" => 300), BX_RESIZE_IMAGE_EXACT);
        } else {
            $result['PREVIEW_PICTURE_M']['src'] = SITE_TEMPLATE_PATH . '/images/no_photo.jpg';
        }
        $result['PRICE'] = $bOb['PRICE'];
        $result['OLD_PRICE'] = $bOb['BASE_PRICE'];

        $result['G'] = $props['G'];
        $result['OPTIONS'] = $content[$_POST['PRODUCT_ID']]['OPTIONS'];
        $result['OPTIONS_NAME'] = array();

        $props_ = array();
        if (!empty($props['BD_PROPS_1'])) {
            foreach ($props['BD_PROPS_1'] as $prop_item) {
                if (!empty($prop_item['VALUE'])) {
                    $props_[$prop_item['PROP']][] = array('VALUE' => $prop_item['VALUE'], 'PRICE' => $prop_item['PRICE'], 'OLD_PRICE' => $prop_item['OLD_PRICE']);
                    $result['OPTIONS_NAME'][1] = $prop_item['PROP'];
                }
            }
        }
        if (!empty($props['BD_PROPS_2'])) {
            foreach ($props['BD_PROPS_2'] as $prop_item) {
                if (!empty($prop_item['VALUE'])) {
                    $props_[$prop_item['PROP']][] = array('VALUE' => $prop_item['VALUE'], 'PRICE' => $prop_item['PRICE'], 'OLD_PRICE' => $prop_item['OLD_PRICE']);
                    $result['OPTIONS_NAME'][2] = $prop_item['PROP'];
                }
            }
        }

        $result['LIKE_COUNTER'] = $props['LIKE_COUNTER'] + Deliverypizza\Entity\LikeTable::getCount(array('PRODUCT_ID' => $content[$_POST['PRODUCT_ID']]['PRODUCT_ID']));
        $result['isLiked'] = intval(Deliverypizza\Entity\LikeTable::getCount(array('PRODUCT_ID' => $content[$_POST['PRODUCT_ID']]['PRODUCT_ID'], 'USER_ID' => $USER->GetID())));
        $result['BD_PROPS'] = $props_;

        echo \Bitrix\Main\Web\Json::encode($result);
        exit;
    } else {
        $result = array();
        $result['TYPE'] = 'constructor';
        $basket_m = new Deliverypizza\Models\Basket();
        $basket = $basket_m->getBasket(0, session_id(), false);
        $basket_res = unserialize($basket['BASKET_CONTENT']);
        $constructor_config = null;
        $constructor_config = $basket_res[$_POST['PRODUCT_ID']];


        $base = CIBlockElement::GetByID($constructor_config['BASE_ID'])->GetNext();
        $souse = CIBlockElement::GetByID($constructor_config['SOUSE_ID'])->GetNext();
        $result['NAME'] = $constructor_config['NAME'];
        $result['PREVIEW_PICTURE']['src'] = $constructor_config['IMAGE'];
        $result['PREVIEW_PICTURE_M']['src'] = $constructor_config['IMAGE'];

        $result['BASE'] = $base['NAME'];
        $result['SOUSE'] = $souse['NAME'];
        $result['INGREDIENTS'] = array();

        if (sizeof($constructor_config['INGREDIENTS'])) {
            foreach ($constructor_config['INGREDIENTS'] as $item) {
                $ing_ = CIBlockElement::GetByID($item)->GetNext();
                $name = $ing_['NAME'];
                if ($constructor_config['ING_AMOUNT'][$item] > 1) {
                    $name .= ' x' . $constructor_config['ING_AMOUNT'][$item];
                }
                $result['INGREDIENTS'][] = $name;
            }
        }
        echo \Bitrix\Main\Web\Json::encode($result);
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action']=='checkPromo') {
    $status = false;
    $_SESSION['PROMO_CODE'] = '';
    if(!empty($_POST['CODE'])) {
        $basket_m = new Aers\BasketController();
        $status = is_array(\Bitrix\Sale\DiscountCouponsManager::isExist($_POST['CODE']));
    }
    \Bitrix\Sale\DiscountCouponsManager::clearApply();
    if ($status) {
        $_SESSION['PROMO_CODE'] = $_POST['CODE'];
        \Bitrix\Sale\DiscountCouponsManager::add($_POST['CODE']);
        $basket_m->checkGift();
    }

    echo \Bitrix\Main\Web\Json::encode(array('status'=>$status));
    exit;
}