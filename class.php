<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
use Bitrix\Main\SystemException;

class CHLBlockRecords extends CBitrixComponent {
    public function executeComponent() {
        $hlBlockID = $this->arParams['HL_BLOCK_ID'];
        if (!is_numeric($hlBlockID)) {
            echo '<p style="color: red;">Некорректный Highload-блок ID.</p>';
            return;
        } else {
            $hlBlockID = intval($hlBlockID);
        }

        Loader::includeModule('highloadblock');

        try {
            $hlBlockEntityDataClass = HLBT::compileEntity(
                HLBT::getById($hlBlockID)->Fetch()
            )->getDataClass();
        } catch (SystemException $e) {
            echo '<p style="color: red;">Highload-блок ID ' . $hlBlockID . ' не найден.</p>';
            return;
        }

        $arQuery = [];

        $sortField = $this->arParams['SORT_FIELD'];
        $sortOrder = $this->arParams['SORT_ORDER'];
        if ($sortField && $sortOrder) {
            $sortOrder = strtoupper($sortOrder);
            if (!($sortOrder == 'ASC' || $sortOrder == 'DESC')) {
                $sortOrder = 'ASC';
            }
            $arQuery['order'] = [$sortField => $sortOrder];
        }

        $filterName = $this->arParams['FILTER_NAME'];
        if ($filterName == '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $filterName)) {
            $arQuery['filter'] = [];
        } else {
            $arQuery['filter'] = $GLOBALS[$filterName];
            if(!is_array($arQuery['filter']))
                $arQuery['filter'] = [];
        }

        $limit = $this->arParams['LIMIT'];
        if (is_numeric($limit)) {
            $limit = intval($limit);
            $arQuery['limit'] = $limit;
        }

        try {
            $rsData = $hlBlockEntityDataClass::getList($arQuery);
        } catch (SystemException $e) {
            unset($arQuery['order']);
            $rsData = $hlBlockEntityDataClass::getList($arQuery);
        }

        $rsData = $hlBlockEntityDataClass::getList($arQuery);
        while($arRecord = $rsData->fetch()) {
            $arRecord['EDIT_LINK'] = $this->getPath() . '/handlers/edit.php?hl_block_id=' . $hlBlockID . '&record_id=' . $arRecord['ID'];
            $arRecord['DELETE_LINK'] = $this->getPath() . '/handlers/delete.php?hl_block_id=' . $hlBlockID . '&record_id=' . $arRecord['ID'];
            $this->arResult[] = $arRecord;
        }

        $this->includeComponentTemplate();
    }
}