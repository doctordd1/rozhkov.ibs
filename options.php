<?php
use Bitrix\Main\{
    Localization\Loc,
    Config\Option,
    HttpApplication,
    Loader
};

$module_id = 'rozhkov.ibs';

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
Loc::loadMessages(__FILE__);
if ($APPLICATION->GetGroupRight($module_id)<="D")
{
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}

Loader::includeModule($module_id);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
    ),
);

if ($request->isPost() && $request['Update'] && check_bitrix_sessid()) {

    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) {
                continue;
            }

            if ($arOption['note']) {
                continue;
            }
            $optionName = $arOption[0];
            $optionValue = $request->getPost($optionName);
            Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue):$optionValue);
        }
    }
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

?>
<? $tabControl->Begin(); ?>
<form method='post'
      action='<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($request['mid'])?>&amp;lang=<?=$request['lang']?>'
      name='rozhkov_ibs_settings'><?
    foreach ($aTabs as $aTab) {
        if($aTab['OPTIONS']) {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
        }
    }

    $tabControl->BeginNextTab();
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");


    $tabControl->Buttons(); ?>

    <input type="submit" name="Update" value="<?=Loc::getMessage('MAIN_SAVE')?>">
    <input type="reset" name="reset" value="<?=Loc::getMessage('MAIN_RESET')?>">
    <?=bitrix_sessid_post();?>
</form>
<? $tabControl->End(); ?>
