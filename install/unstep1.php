<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="rozhkov.ibs">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?= CAdminMessage::ShowMessage(GetMessage("MOD_UNINST_WARN")) ?>
    <p>
        <input type="checkbox" name="delete_db" id="delete_db" value="Y">
        <label for="delete_db"><?= Bitrix\Main\Localization\Loc::getMessage("ROZHKOV_IBS_DELETE_DB") ?></label>
    </p>
    <input type="submit" name="inst" value="<?= Bitrix\Main\Localization\Loc::getMessage("MOD_UNINST_DEL") ?>">
</form>