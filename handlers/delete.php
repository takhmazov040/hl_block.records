<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

if (!$_GET)
    header('Location: /');

Loader::includeModule('highloadblock');

$hlBlockEntityDataClass = HLBT::compileEntity(
    HLBT::getById($_GET['hl_block_id'])->Fetch()
)->getDataClass();

$hlBlockEntityDataClass::Delete($_GET['record_id']);

header('Location: ' . $_GET['return_url']);