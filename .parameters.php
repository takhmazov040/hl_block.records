<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

Loader::includeModule('highloadblock');

$hlBlockList = HLBT::getList()->FetchAll();
$arHLBlocks = [];
foreach ($hlBlockList as $hlBlock) {
    $arHLBlocks[$hlBlock['ID']] = '[' . $hlBlock['ID'] . ']' . $hlBlock['NAME'];
}

$sortOrders = [
    'ASC' => 'По возрастанию',
    'DESC' => 'По убыванию'
];

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'HL_BLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Highload-блок ID',
            'TYPE' => 'LIST',
            'VALUES' => $arHLBlocks,
            'DEFAULT' => $arHLBlocks[0]
        ],
        'SORT_FIELD' => [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Поле сортировки',
            'TYPE' => 'STRING',
            'DEFAULT' => 'ID'
        ],
        'SORT_ORDER' => [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Направление сортировки',
            'TYPE' => 'LIST',
            'VALUES' => $sortOrders,
            'DEFAULT' => $sortOrders[0]
        ],
        'FILTER_NAME' => [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Фильтр',
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],
        'LIMIT' => [
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Количество записей',
            'TYPE' => 'STRING',
            'DEFAULT' => 20
        ]
    ]
];