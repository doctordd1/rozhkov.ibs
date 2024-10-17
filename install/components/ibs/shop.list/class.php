<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\{
    Loader,
    Localization\Loc,
    Grid\Options,
    UI\PageNavigation
};
use Rozhkov\Ibs\Model\{
    BrandTable,
    ModelTable,
    LaptopTable
};

class IbsShopListComponent extends CBitrixComponent
{
    public CONST NAME_PAGE = [
        'brand' => 'Производители',
        'model' => 'Модели',
        'laptop' => 'Ноутбуки',
    ];
    public string $moduleId = 'rozhkov.ibs';
    private string $gridId;

    private function _checkModules(): void
    {
        if (!Loader::includeModule($this->moduleId)) {
            ShowError(Loc::getMessage('IBS_NO_MODULES'));
        }
    }

    private function getGridOptions(): array
    {
        $grid_options = new Options($this->gridId);
        $sort = $grid_options->GetSorting(['sort' => ['ID' => 'ASC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
        $nav_params = $grid_options->GetNavParams();
        $nav = new PageNavigation($this->gridId);
        $nav->allowAllRecords(false)
            ->setPageSize($nav_params['nPageSize'])
            ->initFromUri();
        
        return ['sort' => $sort['sort'], 'nav_object' => $nav];
    }
    private function generateGridID(): void
    {
        $this->gridId = "shop_list_" . $this->arParams['ENTITY'];
    }

    private function getData($typeEntity, $filter = [])
    {   
        $arParams = [
            'order' => $this->arResult['OPTIONS']['sort'], 
            'limit' => intVal($this->arResult['OPTIONS']['nav_object']->getPageSize()),
            'offset' => intVal($this->arResult['OPTIONS']['nav_object']->getCurrentPage()) * intVal($this->arResult['OPTIONS']['nav_object']->getPageSize()) - intVal($this->arResult['OPTIONS']['nav_object']->getPageSize()),
            'count_total' => 1,
        ];
        if ($typeEntity == "brand" ) {
            $ob = BrandTable::getlist($arParams);
        } elseif ($typeEntity == "model") {
            $arParams['filter'] = $filter;
            $ob = ModelTable::getlist($arParams);
        } elseif ($typeEntity == "laptop") {
            $arParams['filter'] = $filter;
            $ob = LaptopTable::getlist($arParams);
        }
        $this->arResult['OPTIONS']['nav_object']->setRecordCount($ob->getCount());
        while ($arElement = $ob->fetch()) {
            $arReturn[] = [
                'data' => $arElement,
                'actions' => [
                    [
                        'text' => 'Открыть',
                        'href' => $arElement['ID'] .'/'
                    ]
                ]
            ];
        }
        return $arReturn;
    }
    private function getColumns($typeEntity){
        if ($typeEntity == "brand" || $typeEntity == "model") {
            return [
                ['id' => 'NAME', 'name' => Loc::getMessage('IBS_GRID_NAME'), 'default' => true, 'sort' => false]
            ];
        } elseif($typeEntity == "laptop") {
            return [
                ['id' => 'NAME', 'name' => Loc::getMessage('IBS_GRID_NAME'), 'default' => true, 'sort' => false],
                ['id' => 'PRICE', 'name' => Loc::getMessage('IBS_GRID_PRICE'), 'default' => true, 'sort' => 'PRICE'],
                ['id' => 'YEAR', 'name' => Loc::getMessage('IBS_GRID_YEAR'), 'default' => true, 'sort' => 'YEAR']
            ];
        }
    }

    public function executeComponent()
    {
        $this->_checkModules();
        $this->generateGridID();
        $this->arResult['OPTIONS'] = $this->getGridOptions();
        $this->arResult['GRID_ID'] = $this->gridId;
        $this->arResult['ROWS'] = $this->getData($this->arParams['ENTITY'], $this->arParams['FILTER']);
        $this->arResult['COLUMNS'] = $this->getColumns($this->arParams['ENTITY']);
        $this->arResult['NAME_PAGE'] = self::NAME_PAGE[$this->arParams['ENTITY']];
        $this->IncludeComponentTemplate($componentPage);
    }
}
