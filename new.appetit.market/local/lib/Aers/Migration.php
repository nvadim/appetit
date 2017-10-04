<?php

namespace Aers;
use Bitrix\Catalog\PriceTable;
use Bitrix\Catalog\ProductTable;
use Bitrix\Main\Loader;

/**
 * Created by PhpStorm.
 * User: WORK-1
 * Date: 02.09.2017
 * Time: 18:21
 */
class Migration
{

    /*TODO
        Установить модули: Валюты, Каталог, Магазин
        Назначить блок каталогом
        Создать базовую цену
        Задать скидку на раздел подарков
    */
    const IBLOCK_ID = 47;

    protected $priseCode;

    public function start()
    {
        $this->prepaidParams();

        //$this->setCatalogField();
    }

    protected function prepaidParams()
    {
        Loader::includeModule('iblock');
        Loader::includeModule('catalog');
        $arBaseType = \CCatalogGroup::GetBaseGroup();
        $this->priseCode = $arBaseType['ID'];
    }
    protected function setCatalogField()
    {
        $items = $this->getAllItem();
        foreach ($items as $item) {
            if ($this->addCatalogItem($item)) {
                $this->addPrice($item);
            }
        }
    }

    protected function getAllItem ()
    {
        $result = array();

        $db = \CIBlockElement::GetList(
            array(),
            array('IBLOCK_ID' => self::IBLOCK_ID),
            false,
            false,
            array('ID', 'IBLOCK_ID', 'PROPERTY_PRICE', 'PROPERTY_G')
        );

        while ($item = $db->Fetch()) {
            $result[] = $item;
        }

        return $result;
    }

    protected function addCatalogItem($item)
    {
        $field = array(
            'ID' => $item['ID'],
            'AVAILABLE' => 'Y',
            'QUANTITY_TRACE' => 'N',
            'CAN_BUY_ZERO' => 'Y',
            'WEIGHT' => (int)$item['PROPERTY_G_VALUE'],
        );
        $result = ProductTable::add($field);

        return $result->isSuccess();
    }

    protected function addPrice($item)
    {
        $field = array(
            'PRODUCT_ID' => $item['ID'],
            'CATALOG_GROUP_ID' => $this->priseCode,
            'PRICE' => (float)$item['PROPERTY_PRICE_VALUE'],
            'CURRENCY' => 'RUB'
        );

        \CPrice::Add($field);
    }
}
