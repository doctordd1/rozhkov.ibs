<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\{
    Loader,
    Application,
    UI\Extension
};
use Rozhkov\Ibs\Model\LaptopTable;

Extension::load('ui.bootstrap4');

class IbsShopDetailComponent extends CBitrixComponent
{
    public string $moduleId = 'rozhkov.ibs';
    private function _checkModules(): void
    {
        if (!Loader::includeModule($this->moduleId)) {
            ShowError(Loc::getMessage('IBS_NO_MODULES'));
        }
    }

    function getData($id)
    {   
        $laptop = LaptopTable::getByPrimary($id, [
            'select' => [ '*', 'OPTIONS', 'MODEL', 'MODEL.BRAND']
        ])->fetchObject();;
        $arReturn = [];
        $arReturn['LAPTOP'] = $laptop->collectValues();
        $model = $laptop->getModel();
        $arReturn['MODEL'] =  $model->collectValues();
        $brand = $model->getBrand();
        $arReturn['BRAND'] =  $brand->collectValues();
        foreach ($laptop->getOptions() as $option)
        {
            $arReturn['OPTIONS'][] = $option->collectValues();
        }
        return $arReturn;

    }
    public function executeComponent()
    {
        $this->_checkModules();
        $this->arResult['DATA'] = $this->getData($this->arParams['ID']);
        $this->IncludeComponentTemplate($componentPage);
    }
}
