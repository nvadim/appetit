<?php
/**
 * Created by PhpStorm.
 * User: Komp
 * Date: 05.09.2017
 * Time: 7:45
 */

namespace Aers;

use Bitrix\Main\Loader;
use \Bitrix\Sale\Basket;
use Bd\Deliverypizza\Entity\UserTable;
use Bitrix\Iblock;
use Bd\Deliverypizza\Entity\BasketTable;
use Bitrix\Main\Localization\Loc;

class BasketController extends \Bd\Deliverypizza\Models\Basket
{
    function __construct()
    {
        Loader::includeModule('sale');
        Loader::includeModule('iblock');
    }

    protected function recalculateBasket()
    {
        \CSaleBasket::UpdateBasketPrices(\CSaleBasket::GetBasketUserID(), SITE_ID);
        $basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), SITE_ID);
        /** @var \Bitrix\Sale\BasketItem $item */
        foreach ($basket as $item) {
            $arProp = $item->getPropertyCollection()->getPropertyValues();
            if (!key_exists('GIFT', $arProp)) {
                $arOrder["BASKET_ITEMS"][] = $item->getFieldValues();
            }
        }
        $arOrder['SITE_ID'] = SITE_ID;
        $arOrder['USER_ID'] = \CUser::GetID();
        \CSaleDiscount::DoProcessOrder($arOrder,array(),$arErrors);
        return $arOrder;
    }

    public function getBasket()
    {
        $result = array();
        if ($_SESSION['PROMO_CODE']) {
            $this->recalculateBasket();
        }
        $basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), SITE_ID);

        /** @var \Bitrix\Sale\BasketItem $bItem */
        foreach ($basket as $bItem) {
            $arProp = $bItem->getPropertyCollection()->getPropertyValues();
            if (!key_exists('GIFT', $arProp)) {
                $content[$bItem->getId()] = array(
                    'ID' => $bItem->getId(),
                    'PRODUCT_ID' => $bItem->getProductId(),
                    'AMOUNT' => $bItem->getQuantity(),
                    'PRICE' => $bItem->getPrice(),
                    'BASE_PRICE' => $bItem->getBasePrice(),
                );
            } else {
                $content['gift'] = array(
                    'ID' => $bItem->getId(),
                    'PRODUCT_ID' => 'gift',
                    'AMOUNT' => $bItem->getQuantity(),
                    'PRICE' => $bItem->getPrice(),
                    'BASE_PRICE' => $bItem->getBasePrice(),
                    'IS_GIFT' => 1,
                    'GIFT_ID' => $bItem->getProductId(),
                    'GIFT_SUM' => $arProp['GIFT_SUM']['VALUE']
                );
            }

        }
        $result = array('SUM' => $basket->getPrice(), 'BASKET_CONTENT' => serialize($content));

        return $result;
    }

    public function getBasketContent()
    {
        $this->recalculateBasket();
        $this->checkGift();

        $basket = Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), SITE_ID);

        /** @var \Bitrix\Sale\BasketItem $bItem */
        foreach ($basket as $bItem) {
            $arProp = $bItem->getPropertyCollection()->getPropertyValues();
            if (!key_exists('GIFT', $arProp)) {
                $arBasket[] = $bItem->getFieldValues();
                $ids[] = $bItem->getProductId();
            } else {
                $gift = $bItem->getFieldValues();
            }
        }
        $basketSum = $basket->getPrice();
        if ($_SESSION['PROMO_CODE']) {
            $tmpOrder = $this->recalculateBasket();
            $arBasket = $tmpOrder['BASKET_ITEMS'];
            $basketSum = $tmpOrder['ORDER_PRICE'];
        }
        $result = array(
            'products' => array(),
            'basket_sum' => (int)$basketSum,
            'basket_sum_gift' => (int)$basketSum,
        );
        $_SESSION['BASKET_SUM'] = (int)$basketSum;
        $_SESSION['BASKET_SUM_GIFT'] = (int)$basketSum;
        if (count($ids) > 0) {
            $arSelect = Array('ID', "NAME", "PREVIEW_PICTURE", 'IBLOCK_SECTION_ID');
            $arFilter = Array("IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_content_pizza"]["bd_catalog"][0], 'ID' => $ids);
            $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNext()) {
                foreach ($arBasket as $index => $bi) {
                    $id_i = $ob['ID'];
                    if ($bi['PRODUCT_ID'] == $ob['ID']) {

                        $item_ = array();
                        $item_['INDEX'] = $bi['ID'];
                        $item_['SORT2'] = $index;
                        $item_['ID'] = $ob['ID'];
                        $item_['NAME'] = $ob['NAME'];

                        $item_['SORT'] = 100;
                        $item_['CLASSES'] = '';
                        $item_['APPEND_WITHOUT_SALE'] = '';

                        if ($ob['PROPERTY_NO_SALE_VALUE'] == 'Y')
                            $item_['APPEND_WITHOUT_SALE'] = 'without_sale';

                        $item_['PRICE'] = $bi['PRICE'];
                        $item_['BASE_PRICE'] = $bi['BASE_PRICE'];
                        $item_['LOCAL_SUM'] = $bi['PRICE'] * $bi['QUANTITY'];

                        $item_['AMOUNT'] = (int)$bi['QUANTITY'];

                        if ($ob['PREVIEW_PICTURE']) {
                            $file = \CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], Array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_EXACT);
                        } else {
                            $file['src'] = SITE_TEMPLATE_PATH . '/images/no_photo.jpg';
                        }

                        $item_['IMAGE'] = \CUtil::GetAdditionalFileURL($file['src']);
                        $res_ = \CIBlockSection::GetByID($ob["IBLOCK_SECTION_ID"]);
                        if ($ar_res = $res_->GetNext()) {
                            if ($ar_res['DEPTH_LEVEL'] == 2) {
                                $ar_res = \CIBlockSection::GetByID($ar_res["IBLOCK_SECTION_ID"])->GetNext();
                            }
                            $item_['SECTION'] = $ar_res['NAME'];
                            $item_['SECTION_ID'] = $ar_res['ID'];
                            $sections[] = $ar_res['ID'];
                        }
                        $products[$id_i] = $item_;
                    }
                }
            }

            if ($gift) {
                $arSelect = Array('ID', "NAME", "PREVIEW_PICTURE", "PROPERTY_PRICE", 'IBLOCK_NAME');
                $arFilter = Array("IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_gifts_pizza"]["bd_gifts"][0], 'ID' => $gift['PRODUCT_ID']);
                $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($ob = $res->GetNext()) {
                    $gift_i['ID'] = 'gift';
                    $gift_i['INDEX'] = $gift['ID'];
                    $gift_i['SORT2'] = count($products);
                    $gift_i['GIFT_ID'] = $gift['PRODUCT_ID']['GIFT_ID'];
                    $gift_i['PRODUCT_ID'] = 'gift';
                    $gift_i['NAME'] = $ob['NAME'];
                    $gift_i['SORT'] = 200;
                    $gift_i['CLASSES'] = 'basket_item_is_gift not_change_amount without_detail';
                    if ($ob['PREVIEW_PICTURE'])
                        $file = \CFile::ResizeImageGet($ob['PREVIEW_PICTURE'], Array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_EXACT);
                    else
                        $file['src'] = SITE_TEMPLATE_PATH . '/images/no_photo.jpg';
                    $gift_i['IMAGE'] = \CUtil::GetAdditionalFileURL($file['src']);
                    $gift_i['PRICE'] = intval($ob['PROPERTY_PRICE_VALUE']);
                    $gift_i['LOCAL_SUM'] = intval($ob['PROPERTY_PRICE_VALUE']);
                    $gift_i['SECTION'] = GetMessage("item_gift");
                    $gift_i['SECTION_ID'] = 'gifts';
                    $products['gift'] = $gift_i;
                }
            }
            usort($products, function ($item1, $item2) {
                if ($item1['SORT2'] == $item2['SORT2']) return 0;
                return $item1['SORT2'] < $item2['SORT2'] ? -1 : 1;
            });
            $result['products'] = $products;
        }

        $result['recommendation'] = array();

        $arSelect = Array('ID', "NAME", "PREVIEW_PICTURE", 'PROPERTY_PRICE', 'IBLOCK_SECTION_ID', 'PROPERTY_ADD_ITEM', 'PROPERTY_ADD_CATEGORY', 'PROPERTY_RECOMEND_CATEGORY', 'PROPERTY_BG_COLOR', 'PROPERTY_BUTTON_COLOR', 'PROPERTY_BUTTON_FONT_COLOR', 'PROPERTY_IS_BANER', 'PROPERTY_URL_BANNER');
        $arFilter = Array("IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[$_SESSION['SITE_ID']]["bd_content_pizza"]["bd_recommendation"][0], 'PROPERTY_IS_BANER_VALUE' => 'Y', 'ACTIVE' => 'Y');
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

        while ($ob = $res->GetNext()) {
            if (!empty($ob['PROPERTY_URL_BANNER_VALUE'])) {
                $ob['URL'] = $ob['PROPERTY_URL_BANNER_VALUE'];
            } else {
                $res_ = \CIBlockSection::GetByID($ob["PROPERTY_RECOMEND_CATEGORY_VALUE"]);
                if ($ar_res_ = $res_->GetNext()) {
                    $ob['URL'] = $ar_res_['SECTION_PAGE_URL'];
                }
            }
            $ob['IMAGE'] = \CFile::GetFileArray($ob['PREVIEW_PICTURE']);
            $ob['IMAGE']['SRC'] = \CUtil::GetAdditionalFileURL($ob['IMAGE']['SRC']);
            $result['recommendation']['single'] = $ob;
        }
        $result['promo'] = $_SESSION['PROMO_CODE'];

        return $result;
    }

    public function checkGift()
    {
        $info = $this->getBasket();
        $content = unserialize($info['BASKET_CONTENT']);
        if ($info['SUM'] < $content['gift']['GIFT_SUM']) {
            $this->removeGift($content['gift']['ID']);
        }
    }
    public function removeGift($id = false)
    {
        if (!$id) {
            $info = $this->getBasket();
            $content = unserialize($info['BASKET_CONTENT']);
            $id = $content['gift']['ID'];
        }
        if ($id > 0) {
            $this->removeItem($id);
            unset($_SESSION['GIFT_ID']);
        }
    }

    public function changeAmount($id, $quantity)
    {
        return \CSaleBasket::Update($id, array('QUANTITY' => $quantity));
    }

    public function removeItem($id)
    {
        return \CSaleBasket::Delete($id);
    }
}