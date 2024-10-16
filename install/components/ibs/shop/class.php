<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\{
    Loader,
    Application,
    Localization\Loc,
};

class IbsShopComponent extends CBitrixComponent
{
    public $moduleId = "rozhkov.ibs";
    public function executeComponent()
    {
        $this->_checkRights();
        if ($this->arParams["SEF_MODE"] === "Y") {
            $componentPage = $this->sefMode();
        }
        if ($this->arParams["SEF_MODE"] != "Y") {
            $componentPage = $this->noSefMode();
        }
        if (!$componentPage) {
            Tools::process404(
                $this->arParams["MESSAGE_404"],
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SHOW_404"] === "Y"),
                $this->arParams["FILE_404"]
            );
        }
        $this->IncludeComponentTemplate($componentPage);
    }
    protected function sefMode()
    {
        $arComponentVariables = [
            'sort'
        ];
        $arDefaultVariableAliases404 = array( );
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
            $arDefaultVariableAliases404,
            $this->arParams["VARIABLE_ALIASES"]
        );

        $arDefaultUrlTemplates404 = [
            "model" => "#BRAND#/",
            "laptop" => "#BRAND#/#MODEL#/",
            "laptop_detail" => "#BRAND#/#MODEL#/#LAPTOP#/",
        ];
        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams["SEF_URL_TEMPLATES"]
        );
        $engine = new CComponentEngine($this);
        $arVariables = [];
        $componentPage = $engine->guessComponentPath(
            $this->arParams["SEF_FOLDER"],
            $this->arParams["SEF_URL_TEMPLATES"],
            $arVariables
        );

        if ($componentPage == FALSE) {
            $componentPage = 'brand';
        }
        
        CComponentEngine::initComponentVariables(
            $componentPage,
            $arComponentVariables,
            $arVariableAliases,
            $arVariables
        );

        $this->arResult = [
            "VARIABLES" => $arVariables,
            "ALIASES" => $arVariableAliases
        ];
        return $componentPage;
    }
    /**
     * Просто чтобы был. Работать не в режиме ЧПУ - компонент не будет, из за генерации ссылок
     */
    protected function noSefMode()
    {
        $arDefaultVariableAliases = [
            'ELEMENT_COUNT' => 'count',
        ];
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
            $arDefaultVariableAliases,
            $this->arParams["VARIABLE_ALIASES"]
        );
        $arVariables = [];
        $arComponentVariables = [
            'sort'
        ];
        CComponentEngine::initComponentVariables(
            false,
            $arComponentVariables,
            $arVariableAliases,
            $arVariables
        );
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        $rDir = $request->getRequestedPageDirectory();
        $componentPage = "";
        if ($arVariableAliases["CATALOG_URL"] == $rDir) {
            $componentPage = "brand";
        }
        if ((isset($arVariables["BRAND_ID"]) && intval($arVariables["BRAND_ID"]) > 0)) {
            $componentPage = "model";
        }
        if ((isset($arVariables["MODEL_ID"]) && intval($arVariables["MODEL_ID"]) > 0) ) {
            $componentPage = "laptop";
        }
        if ((isset($arVariables["LAPTOP_ID"]) && intval($arVariables["LAPTOP_ID"]) > 0) ) {
            $componentPage = "laptop_detail";
        }
        $this->arResult = [
            "VARIABLES" => $arVariables,
            "ALIASES" => $arVariableAliases
        ];
        return $componentPage;
    }
    private function _checkRights(): void
    {
        global $APPLICATION;
        if ($APPLICATION->GetGroupRight($this->moduleId) <= "D") {
            $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
        }

    }
}