<?
use Bitrix\Main\{
	Localization\Loc,
	Entity\Base,
	Loader,
	Application,
	ModuleManager
};

Loc::loadMessages(__FILE__);

class rozhkov_ibs extends CModule
{
	public $MODULE_ID = 'rozhkov.ibs';
	public $MODULE_NAME = '';
	public $MODULE_DESCRIPTION = '';
	public $PARTNER_NAME = "rozhkov";
	public $PARTNER_URI = "";

	public function __construct()
	{
		$version = include __DIR__ . '/version.php';
		$this->MODULE_VERSION = $version['VERSION'];
		$this->MODULE_VERSION_DATE = $version['VERSION_DATE'];
		$this->MODULE_NAME = Loc::getMessage('ROZHKOV_IBS_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('ROZHKOV_IBS_MODULE_DESCRIPTION');
		$this->documentRoot = Application::getDocumentRoot();
	}

	private function installDB()
	{
		Loader::includeModule($this->MODULE_ID);
		Base::getInstance('\rozhkov\ibs\model\BrandTable')->createDbTable();
		Base::getInstance('\rozhkov\ibs\model\ModelTable')->createDbTable();
		Base::getInstance('\rozhkov\ibs\model\LaptopOptionTable')->createDbTable();
		Base::getInstance('\rozhkov\ibs\model\OptionTable')->createDbTable();
		Base::getInstance('\rozhkov\ibs\model\LaptopTable')->createDbTable();
	}

	private function unInstallDB()
	{
		Loader::includeModule($this->MODULE_ID);
		$connection = Application::getConnection();
		$connection->queryExecute('DROP TABLE IF EXISTS ' . Base::getInstance('\rozhkov\ibs\model\BrandTable')->getDBTableName());
		$connection->queryExecute('DROP TABLE IF EXISTS ' . Base::getInstance('\rozhkov\ibs\model\ModelTable')->getDBTableName());
		$connection->queryExecute('DROP TABLE IF EXISTS ' . Base::getInstance('\rozhkov\ibs\model\LaptopOptionTable')->getDBTableName());
		$connection->queryExecute('DROP TABLE IF EXISTS ' . Base::getInstance('\rozhkov\ibs\model\OptionTable')->getDBTableName());
		$connection->queryExecute('DROP TABLE IF EXISTS ' . Base::getInstance('\rozhkov\ibs\model\LaptopTable')->getDBTableName());
	}

	private function installFiles()
	{
        CopyDirFiles($this->documentRoot."/local/modules/$this->MODULE_ID/install/components",
            $this->documentRoot."/local/components", true, true);
		return true;
	}

	private function unInstallFiles()
	{
		\Bitrix\Main\IO\Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . '/local/components/ibs/');
		return true;
	}

	private function addTestData(){
		$brands = ['ASUS','ACER', 'Apple'];
		$model = 'Модель';
		$laptop = 'Ноутбук';
		$option = 'Опция';
		foreach ($brands as $brand) {
			Rozhkov\Ibs\Model\BrandTable::add(['NAME' => $brand]);
		}
		for ($i=0; $i < 20; $i++) { 
			Rozhkov\Ibs\Model\ModelTable::add(['NAME' => $model . " " . $i, 'BRAND_ID' => rand(1,3) ]);
		}
		for ($i=0; $i < 100; $i++) { 
			Rozhkov\Ibs\Model\OptionTable::add(['NAME' => $option . " " . $i]);
		}
		for ($i=0; $i < 100; $i++) { 
			$newLaptop = Rozhkov\Ibs\Model\LaptopTable::createObject();
			$newLaptop->setName($laptop . " " . $i);
			for ($j=1; $j < rand(5,15); $j++) { 
				$option = Rozhkov\Ibs\Model\OptionTable::getByPrimary(rand(1,100))->fetchObject();
				$newLaptop->addToOptions($option);
			}
			$newLaptop->set("MODEL_ID",rand(1,20));
			$newLaptop->set("YEAR",rand(1980, 2022));
			$newLaptop->set("PRICE",rand(100000, 1000000) / 100);
			$newLaptop->save();
		}
 	}

	private function DoInstall()
	{
		global $APPLICATION;
		$context = Application::getInstance()->getContext();
        $request = $context->getRequest();
		if ($request["step"] < 2) {
			$APPLICATION->IncludeAdminFile(Loc::getMessage("ROZHKOV_IBS_MODULE_NAME"), $this->documentRoot . "/local/modules/$this->MODULE_ID/install/step1.php");
		} elseif ($request["step"] == 2) {
			$this->InstallFiles();
			ModuleManager::registerModule($this->MODULE_ID);
			if ($request["delete_db"] == "Y") {
				$this->unInstallDB();
			}
			$this->installDB();
			if ($request['add_data'] == "Y") {
				$this->addTestData();
			}
		} else {
			$APPLICATION->IncludeAdminFile(Loc::getMessage("ROZHKOV_IBS_MODULE_NAME"), $this->documentRoot . "/local/modules/$this->MODULE_ID/install/step2.php");
		}
	}

	private function DoUninstall()
	{
		global $APPLICATION;
		$context = Application::getInstance()->getContext();
        $request = $context->getRequest();
		
		if($request['step'] < 2) {
            $APPLICATION->IncludeAdminFile(GetMessage("ROZHKOV_IBS_MODULE_UNINSTALL_TITLE"),
                $this->documentRoot . "/local/modules/$this->MODULE_ID/install/unstep1.php");

        } elseif($request['step'] == 2) {
			$this->unInstallFiles();
            if($request['delete_db'] == 'Y') {
                $this->UnInstallDB();
            }
            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

            $APPLICATION->IncludeAdminFile(GetMessage("ROZHKOV_IBS_MODULE_UNINSTALL_TITLE"),
                $this->documentRoot . "/local/modules/$this->MODULE_ID/install/unstep2.php");
        }
		$this->unInstallDB();
		ModuleManager::unRegisterModule($this->MODULE_ID);

	}

}