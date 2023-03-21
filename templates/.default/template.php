<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$this->setFrameMode(true);

?>

<? foreach ($arResult as $item): ?>
    <?
    $this->AddEditAction($item['ID'], $item['EDIT_LINK']);
    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK']);
    ?>
    <p id="<?= $this->GetEditAreaId($item['ID']);?>"><?= $item['ID']; ?></p>
<? endforeach; ?>