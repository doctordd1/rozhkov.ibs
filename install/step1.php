<?php
use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">

    <input type="hidden" name="id" value="rozhkov.ibs">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <p><?= Loc::getMessage("MOD_ADD_DATA") ?></p>
    <p><input type="checkbox" name="add_data" id="add_data" value="Y" checked><label for="add_data"><?= Loc::getMessage("MOD_ADD_DATA_BUTTON") ?></label></p>
    <p><?= Loc::getMessage("MOD_DELETE_DB_IF_EXIST") ?></p>
    <p><input type="checkbox" name="delete_db" id="delete_db" value="Y" checked><label for="delete_db"><?= Loc::getMessage("MOD_DELETE_DB_IF_EXIST_BUTTON") ?></label></p>
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_INSTALL") ?>">
</form>