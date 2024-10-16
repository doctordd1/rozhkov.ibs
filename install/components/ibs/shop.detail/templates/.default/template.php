
<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
$APPLICATION->setTitle($arResult['DATA']['LAPTOP']['NAME']);

?>
<div class="card">
    <div class="card-header">
        <?=$arResult['DATA']['LAPTOP']['NAME']?>
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text"><?=Loc::getMessage('BRAND_NAME') . ' - ' . $arResult['DATA']['BRAND']['NAME'] ?></p>
            <p class="card-text"><?=Loc::getMessage('MODEL_NAME') . ' - ' . $arResult['DATA']['MODEL']['NAME']?></p>
            <p class="card-text"><?=Loc::getMessage('PRICE') . ' - ' . $arResult['DATA']['LAPTOP']['PRICE']?></p>
            <p class="card-text"><?=Loc::getMessage('YEAR') . ' - ' . $arResult['DATA']['LAPTOP']['YEAR']?></p>
            <p><?=Loc::getMessage('OPTIONS')?>:</p>
            <?foreach ($arResult['DATA']['OPTIONS'] as $option) {?>
                <footer class="blockquote-footer"><?=$option['NAME']?></footer><br>
            <?}?>
        </blockquote>
    </div>
</div>
